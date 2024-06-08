<?php

namespace App\Controllers;
class Controller {
    protected function render(string $view, array $data = []): void
    {
        extract($data);

        include "Views/$view.php";
    }
}