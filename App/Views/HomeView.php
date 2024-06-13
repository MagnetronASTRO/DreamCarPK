<h1>Available Cars</h1>
<div class="cars-wrapper">
    <form action="/car_page" method="post">
        <?php foreach ($cars as $car): ?>
            <button class="car-wrapper-submit" type="submit" name="carId" value="<?= $car->id ?>">
                <div class="car-gallery-container">
                    <div class="car-gallery">
                        <div class="img-container">
                            <img class="car-photo" src="img/<?= $car->carPhoto ?>?v=<?= filemtime('img/' . $car->carPhoto) ?>" alt="submit">
                        </div>
                        <div class="car-description">
                            <strong class="car-name-bold"> <?= htmlspecialchars($car->make) ?> <?= htmlspecialchars($car->model) ?></strong>
                            <p class="car-availability <?= $car->is_available ? 'car-is-available' : 'car-is-not-available' ?>"><?= $car->is_available ? 'Available' : 'Not Available' ?></p>
                        </div>
                    </div>
                </div>
            </button>
        <?php endforeach; ?>
    </form>
</div>
