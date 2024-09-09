<?php if ($car): ?>
    <h1><?= htmlspecialchars($car->make) ?> <?= htmlspecialchars($car->model) ?> (<?= htmlspecialchars($car->year) ?>)</h1>
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
                    <td><strong>Day Price:</strong></td>
                    <td>$<?= htmlspecialchars($car->carPricing['day_price']) ?></td>
                </tr>
                <tr>
                    <td><strong>Month Price:</strong></td>
                    <td>$<?= htmlspecialchars($car->carPricing['month_price']) ?></td>
                </tr>
                <tr>
                    <td><strong>Per KM Price:</strong></td>
                    <td>$<?= htmlspecialchars($car->carPricing['km_price']) ?></td>
                </tr>
                <tr>
                    <td><strong>Availability:</strong></td>
                    <td class="<?= $car->is_available ? 'car-is-available' : 'car-is-not-available' ?>"><?= $car->is_available ? 'Available' : 'Not Available' ?></td>
                </tr>
            </table>
        </div>
    </div>
    <h3 class="section-title">Reserve car:</h3>
    <?php if (!empty($_COOKIE['user_token']) && $car->is_available): ?>
        <form class="rent-car" action="/rent_car/" id="addReservationForm" method="post">
            <input type="hidden" name="carId" value="<?= $car->id ?>">
            <label for="reservationDate">Reservation Date:</label>
            <input type="date" id="reservationDate" name="reservationDate" required>
            <label for="returnDate">Return Date:</label>
            <input type="date" id="returnDate" name="returnDate" required>
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
