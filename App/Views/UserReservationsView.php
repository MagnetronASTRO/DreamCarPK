<h1>Your reservations</h1>
    <div class="reservations-wrapper">
        <?php
        $defaultPhoto = "default/vecteezy_car-icon-vector-illustration_.jpg";

        ?>

        <div class="reservations-header">
            <div>START</div>
            <div>END</div>
            <div>CAR</div>
        </div>

        <?php foreach ($reservations as $reservation): ?>
            <div class="reservation-container">
                <div class="start-time">
                    <?= htmlspecialchars($reservation->fromDate) ?>
                </div>
                <div class="return-time">
                    <?= htmlspecialchars($reservation->returnDate) ?>
                </div>
                <div class="reserved-car">
                    <span><?= htmlspecialchars($reservation->car->make) ?></span>
                    <span> <?= htmlspecialchars($reservation->car->model) ?></span>
                    <span> <?= htmlspecialchars($reservation->car->year) ?></span>
                </div>
            </div>
        <?php endforeach; ?>
    </div>