<h1>Available Cars</h1>
<form action="/car_page" method="post">
    <div class="cars-wrapper">
        <?php
        $defaultPhoto = "default/vecteezy_car-icon-vector-illustration_.jpg";

        foreach ($cars as $car): ?>
            <button class="car-wrapper-submit" type="submit" name="carId" value="<?= $car->getId() ?>">
                <div class="car-gallery-container">
                    <div class="car-gallery">
                        <div class="img-container">
                            <?php if (empty($car->getCarPhoto()) || !file_exists("img/$car->getCarPhoto()")): ?>
                                <img src="<?= $defaultPhoto ?>?v=<?= filemtime($defaultPhoto) ?>" alt="<?= htmlspecialchars($car->getMaker()) ?> <?= htmlspecialchars($car->getModel()) ?>">
                            <?php else: ?>
                                <img src="img/<?= $car->getCarPhoto() ?>?v=<?= filemtime('img/' . $car->getCarPhoto()) ?>" alt="<?= htmlspecialchars($car->getMaker()) ?> <?= htmlspecialchars($car->getModel()) ?>">
                            <?php endif; ?>
                        </div>
                        <div class="car-description">
                            <strong class="car-name-bold"> <?= htmlspecialchars($car->getMaker()) ?> <?= htmlspecialchars($car->getModel()) ?></strong>
                            <p class="car-availability <?= $car->getIsAvailable() ? 'car-is-available' : 'car-is-not-available' ?>"><?= $car->getIsAvailable() ? 'Available' : 'Not Available' ?></p>
                        </div>
                    </div>
                </div>
            </button>
        <?php endforeach; ?>
    </div>
</form>