<?php
$scriptsPaths = [
    'js/sign_in.js',
    'js/sign_up.js',
    'js/logout.js',
    'js/header.js',
    'js/footer.js', // adds current year to copyright
//    'js/admin_users.js',
//    'js/admin_cars.js',
//    'js/admin_reservations.js',
];

$stylesPaths = [
    'css/main_styles.css',
    'css/login_register_styles.css',
    'css/navbar_styles.css',
    'css/home_styles.css',
    'css/car_details_styles.css',
    'css/admin_panel_styles.css',
    'css/reservations_styles.css',
];

foreach ($scriptsPaths as $scriptPath) {
    $version = filemtime($scriptPath);
    echo "<script src=" . $scriptPath . "?v=" . $version . "></script>";
}

foreach ($stylesPaths as $stylePath) {
    $version = filemtime($stylePath);
    echo "<link rel='stylesheet' type='text/css' href=" . $stylePath . "?v=" . $version . ">";
}
