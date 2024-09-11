<?php if ($car): ?>
    <script src='js/reservations.js?v=<?= filemtime('js/reservations.js') ?>'></script>

    <h3><?= htmlspecialchars($car->make) ?> <?= htmlspecialchars($car->model) ?> (<?= htmlspecialchars($car->year) ?>)</h3>
    <div class="car-details">
        <div class="car-photo-container">
            <?php
            $defaultPhoto = "default/vecteezy_car-icon-vector-illustration_.jpg";
            if (!file_exists("img/$car->carPhoto")): ?>
                <img src="<?= $defaultPhoto ?>?v=<?= filemtime($defaultPhoto) ?>" alt="<?= htmlspecialchars($car->make) ?> <?= htmlspecialchars($car->model) ?>">
           <?php else: ?>
                <img src="img/<?= $car->carPhoto ?>?v=<?= filemtime('img/' . $car->carPhoto) ?>" alt="<?= htmlspecialchars($car->make) ?> <?= htmlspecialchars($car->model) ?>">
            <?php endif; ?>
        </div>
        <div class="specs-and-form-container">
            <div class="car-specs">
                <h3 class="section-title">Car specs:</h3>
                <table>
                    <tr>
                        <td><strong>Power:</strong></td>
                        <td><?= htmlspecialchars($car->carSpecs['power']) ?> HP</td>
                    </tr>
                    <tr>
                        <td><strong>Color:</strong></td>
                        <td><?= htmlspecialchars($car->carSpecs['color']) ?></td>
                    </tr>
                    <tr>
                        <td><strong>Hour Price:</strong></td>
    <!--                    TODO: remove 4.00 holder-->
                        <td id="pricePerHour">$<?= htmlspecialchars($car->carPricing['hour_price'] ?? 4.00) ?></td>
                    </tr>
                    <tr>
                        <td><strong>Availability:</strong></td>
                        <td class="<?= $car->is_available ? 'car-is-available' : 'car-is-not-available' ?>"><?= $car->is_available ? 'Available' : 'Not Available' ?></td>
                    </tr>
                </table>
            </div>
            <div class="rent-car-form">
                <h3 class="section-title">Reserve car:</h3>
                <?php if (!empty($_COOKIE['user_token']) && $car->is_available): ?>
                    <form class="rent-car" action="/rent_car/" id="addReservationForm" method="post">
                        <input type="hidden" name="carId" value="<?= $car->id ?>">
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
                <?php elseif (!$car->is_available): ?>
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
