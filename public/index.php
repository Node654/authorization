<?php

if (PHP_MAJOR_VERSION < 8) {
    die('Версия php больше или равна 8');
}

session_start();

require_once '../config/params.php';
require_once ROOT . '/routes/routes.php';

use Auth\App\App;

App::run();

