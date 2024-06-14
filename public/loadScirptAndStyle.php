<?php
$scriptsPaths = [
    'js/sign_in.js',
    'js/sign_up.js',
    'js/footer.js', // adds current year to copyright
];

$stylesPaths = [
    'css/main_styles.css',
    'css/login_register_styles.css',
    'css/navbar_styles.css',
    'css/home_styles.css',
    'css/car_details_styles.css',
];

foreach ($scriptsPaths as $scriptPath) {
    $version = filemtime($scriptPath);
    echo "<script src=" . $scriptPath . "?v=" . $version . "></script>";
}

foreach ($stylesPaths as $stylePath) {
    $version = filemtime($stylePath);
    echo "<link rel='stylesheet' type='text/css' href=" . $stylePath . "?v=" . $version . ">";
}
