<?php

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Главная страница</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .navbar { overflow: hidden; background-color: #333; }
        .navbar a { float: left; display: block; color: #f2f2f2; text-align: center; padding: 14px 16px; text-decoration: none; }
        .navbar a:hover { background-color: #ddd; color: black; }
        .main-content { padding: 16px; }
        .user-list { list-style: none; padding: 0; }
        .user-list li { padding: 8px; background-color: #f9f9f9; border: 1px solid #ddd; margin-top: 5px; }
    </style>
</head>
<body>

<div class="navbar">
        <a href="/">Главная</a>
    <?php if (isset($_SESSION['auth'])) { ?>
        <a href="/profile/<?= $user[0]['id']; ?>">Профиль</a>
        <a href="/logout">Выйти</a>
    <?php } else { ?>
        <a href="/register">Регистрация</a>
        <a href="/login">Войти</a>
    <?php } ?>
</div>

</body>
</html>

