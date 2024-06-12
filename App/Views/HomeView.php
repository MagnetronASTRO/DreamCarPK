<body>
<div class="main">
    <h1>Available Cars</h1>
    <div class="cars-wrapper">

        <?php foreach ($cars as $car): ?>
            <div class="car-container">
                <div class="car-name">
                    <h2> <?= htmlspecialchars($car->make) ?> <?= htmlspecialchars($car->model) ?></h2>
                </div>
                <div class="car-photo-container">
                    <img class="car-photo" src="img/<?= $car->carPhoto ?>" alt="<?= $car->carPhoto ?>">
                </div>

                <p><?= $car->is_available ? 'Available' : 'Not Available' ?></p>
            </div>
        <?php endforeach; ?>

    </div>
</div>