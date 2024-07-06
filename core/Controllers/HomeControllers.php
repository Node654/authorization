<?php

namespace Auth\Controllers;

use Auth\Service\User\User;

class HomeControllers
{
    public static function index()
    {
        extract(['user' => User::select('users', ['id' => $_SESSION['idUser'] ?? ''])]);
        require_once PAGES . '/home.php';
    }
}