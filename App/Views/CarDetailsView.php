<?php if ($car): ?>
    <script src='js/reservations.js?v=<?= filemtime('js/reservations.js') ?>'></script>

    <h3><?= htmlspecialchars($car->getMaker()) ?> <?= htmlspecialchars($car->getModel()) ?> (<?= htmlspecialchars($car->getYear()) ?>)</h3>
    <div class="car-details">
        <div class="car-photo-container">
            <?php
            $defaultPhoto = "default/vecteezy_car-icon-vector-illustration_.jpg";
            if (empty($car->getCarPhoto()) || !file_exists("img/$car->getCarPhoto()")): ?>
                <img src="<?= $defaultPhoto ?>?v=<?= filemtime($defaultPhoto) ?>" alt="<?= htmlspecialchars($car->getMaker()) ?> <?= htmlspecialchars($car->getModel()) ?>">
           <?php else: ?>
                <img src="img/<?= $car->getCarPhoto() ?>?v=<?= filemtime('img/' . $car->getCarPhoto()) ?>" alt="<?= htmlspecialchars($car->getMaker()) ?> <?= htmlspecialchars($car->getModel()) ?>">
            <?php endif; ?>
        </div>
        <div class="specs-and-form-container">
            <div class="car-specs">
                <h3 class="section-title">Car specs:</h3>
                <table>
                    <tr>
                        <td><strong>Power:</strong></td>
                        <td><?= htmlspecialchars($car->getCarSpecs()['power']) ?> HP</td>
                    </tr>
                    <tr>
                        <td><strong>Color:</strong></td>
                        <td><?= htmlspecialchars($car->getCarSpecs()['color']) ?></td>
                    </tr>
                    <tr>
                        <td><strong>Hour Price:</strong></td>
                        <td id="pricePerHour">$<?= htmlspecialchars($car->getCarPricing()['hour_price']) ?></td>
                    </tr>
                    <tr>
                        <td><strong>Availability:</strong></td>
                        <td class="<?= $car->getIsAvailable() ? 'car-is-available' : 'car-is-not-available' ?>"><?= $car->getIsAvailable() ? 'Available' : 'Not Available' ?></td>
                    </tr>
                </table>
            </div>
            <div class="rent-car-form">
                <h3 class="section-title">Reserve car:</h3>
                <?php if (!empty($_COOKIE['user_token']) && $car->getIsAvailable()): ?>
                    <form class="rent-car" action="/rent_car/" id="addReservationForm" method="post">
                        <input type="hidden" name="carId" value="<?= $car->getId() ?>">
                        <label for="fromDate">Reservation Date:</label>
                        <input type="datetime-local" id="fromDate" name="fromDate" required>
                        <label for="returnDate">Return Date:</label>
                        <input type="datetime-local" id="returnDate" name="returnDate" required>
                        <div style="display: block; margin-top: 10px; margin-bottom: 10px;">
                            <label for="totalPrice">Total price:</label>
                            <strong><u><span id="totalpriceDisplay">0.00$</span></u></strong>
                        </div>
                        <button type="submit">Reserve</button>
                    </form>
                <?php elseif (!$car->getIsAvailable()): ?>
                    <p>This car is currently not available for reservation.</p>
                <?php endif; ?>
                <?php if(empty($_COOKIE['user_token'])): ?>
                    <p>You must be logged in to reserve car.</p>
                <?php endif; ?>
                <?php else: ?>
                    <p>Car not found.</p>
                <?php endif; ?>
            </div>
    </div>
