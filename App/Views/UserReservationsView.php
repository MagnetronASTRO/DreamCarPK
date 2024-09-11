<h2>Your reservations:</h2>
    <div class="reservations-wrapper">
        <?php
        $defaultPhoto = "default/vecteezy_car-icon-vector-illustration_.jpg";

        ?>

        <section class="reservation-container">

        <?php
            if (empty($reservations)) {
                echo "<div class='reservation-card'><p>You have no reservations.</p></div>";
            } else {
                foreach ($reservations as $reservation):
                    if ($reservation->isActive === 1): ?>
                        <h3><u>Current rented car:</u></h3>
                    <?php else: ?>
                        <br/>
                        <h3><u>Reservation history:</u></h3>
                    <?php endif; ?>

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
                            <?= htmlspecialchars(date("Y-m-d H:i", strtotime($reservation->fromDate))) ?>
                        </div>
                        <!-- return date -->
                        <div class="table-cell" data-label="returnDate">
                            <span><strong>Return: </strong></span>
                            <?= htmlspecialchars(date("Y-m-d H:i", strtotime($reservation->returnDate))) ?>
                        </div>

                        <?php if ($reservation->isActive === 1): ?>
                            <div class="table-cell" data-label="leftRentTime">
                                <span><strong>Left time: </strong></span>
                                <?php
                                    $returnDate = new DateTimeImmutable($reservation->returnDate);
                                    $currentTime = new DateTimeImmutable();
                                    $interval = $currentTime->diff($returnDate);
                                    echo $interval->format("%a days %Hh %Imin");
                                ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach;
            }
            ?>
        </section>
    </div>