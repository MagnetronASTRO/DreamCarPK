<h3>Your reservations:</h3>
    <div class="reservations-wrapper">
        <?php
        $defaultPhoto = "default/vecteezy_car-icon-vector-illustration_.jpg";

        ?>

        <section class="reservation-container">

        <?php foreach ($reservations as $reservation): ?>
            <div class="reservation-card">
                <!-- Header car data -->
                <div class="table-header">
                    <span>CAR - </span>
                    <span><?= htmlspecialchars($reservation->car->make) ?></span>
                    <span> <?= htmlspecialchars($reservation->car->model) ?></span>
                    <span> <?= htmlspecialchars($reservation->car->year) ?></span>
                </div>
                <!-- start date -->
                <div class="table-cell" data-label="fromDate">
                    <span><strong>Pickup: </strong> </span>
                    <?= htmlspecialchars(date("Y-m-d h:i", strtotime($reservation->fromDate))) ?>
                </div>
                <!-- return date -->
                <div class="table-cell" data-label="returnDate">
                    <span><strong>Return: </strong></span>
                    <?= htmlspecialchars(date("Y-m-d h:i", strtotime($reservation->returnDate))) ?>
                </div>
            </div>
        <?php endforeach; ?>

        </section>
    </div>