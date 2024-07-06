<?php





?>


<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Контактная информация</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .contact-info {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .contact-info h2 {
            color: #333;
            text-align: center;
        }
        .contact-info ul {
            list-style: none;
            padding: 0;
        }
        .contact-info ul li {
            margin-bottom: 10px;
            font-size: 18px;
        }
        .contact-info ul li span {
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="contact-info">
    <?php if (isset($_SESSION['loginSuccess'])) { ?>
        <h2><?= $_SESSION['loginSuccess'] ?></h2>
        <?php unset($_SESSION['loginSuccess']); } ?>
    <h2>Контактная Информация</h2>
    <ul>
        <li><span>Имя:</span> <?= $user[0]['name'] ?></li>
        <li><span>Почта:</span> <?= $user[0]['email'] ?></li>
        <li><span>Телефон:</span> <?= $user[0]['phone'] ?></li>
        <li><a href="/update/<?= $user[0]['id'] ?>">Изменить</a></li>
        <li><a href="/">Главная</a></li>
    </ul>
</div>
</body>
</html>

