<h1>Available Cars</h1>
<form action="/car_page" method="post">
    <div class="cars-wrapper">
        <?php
        $defaultPhoto = "default/vecteezy_car-icon-vector-illustration_.jpg";

        foreach ($cars as $car): ?>
            <button class="car-wrapper-submit" type="submit" name="carId" value="<?= $car->id ?>">
                <div class="car-gallery-container">
                    <div class="car-gallery">
                        <div class="img-container">
                            <?php if (empty($car->carPhoto) || !file_exists("img/$car->carPhoto")): ?>
                                <img src="<?= $defaultPhoto ?>?v=<?= filemtime($defaultPhoto) ?>" alt="<?= htmlspecialchars($car->make) ?> <?= htmlspecialchars($car->model) ?>">
                            <?php else: ?>
                                <img src="img/<?= $car->carPhoto ?>?v=<?= filemtime('img/' . $car->carPhoto) ?>" alt="<?= htmlspecialchars($car->make) ?> <?= htmlspecialchars($car->model) ?>">
                            <?php endif; ?>
                        </div>
                        <div class="car-description">
                            <strong class="car-name-bold"> <?= htmlspecialchars($car->make) ?> <?= htmlspecialchars($car->model) ?></strong>
                            <p class="car-availability <?= $car->is_available ? 'car-is-available' : 'car-is-not-available' ?>"><?= $car->is_available ? 'Available' : 'Not Available' ?></p>
                        </div>
                    </div>
                </div>
            </button>
        <?php endforeach; ?>
    </div>
</form>