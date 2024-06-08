<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\UserModel;

class UserController extends Controller {
    public function index() {
        $users = [
            new UserModel('John Doe', 'john@example.com'),
            new UserModel('Jane Doe', 'jane@example.com')
        ];

        $this->render('user/index', ['users' => $users]);
    }
}
