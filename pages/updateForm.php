<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Форма Регистрации</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        input[type=text],
        input[type=tel],
        input[type=email],
        input[type=password] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box; /* Добавляет padding в общую ширину элемента */
        }
        input[type=submit] {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #5cb85c;
            color: white;
            cursor: pointer;
            margin-top: 10px;
        }
        input[type=submit]:hover {
            background-color: #4cae4c;
        }
    </style>
</head>
<body>

<form method="post" action="/update">
    <input type="hidden" name="id" value="<?= $user[0]['id'] ?>">
    <div>
        <?php if (isset($_SESSION['errors']['name'])) {?>
            <p><?= $_SESSION['errors']['name'][0]; ?></p>
        <?php
            $_SESSION['errors']['name'] = null;}
        ?>
        <input type="text" name="name" placeholder="Имя" value="<?= $user[0]['name'] ?>">
    </div>
    <div>
        <?php if (isset($_SESSION['errors']['phone'])) {?>
            <p><?= $_SESSION['errors']['phone'][0]; ?></p>
            <?php
            $_SESSION['errors']['phone'] = null;
        }
        ?>
        <input type="tel" name="phone" placeholder="+7 123 456-7890" value="<?= $user[0]['phone'] ?>">
    </div>
    <div>
        <?php if (isset($_SESSION['errors']['email'])) {?>
            <p><?= $_SESSION['errors']['email'][0]; ?></p>
            <?php
            $_SESSION['errors']['email'] = null;
        }
        ?>
        <input type="email" name="email" placeholder="Почта" value="<?= $user[0]['email'] ?>">
    </div>
    <div>
        <?php if (isset($_SESSION['errors']['password'])) {?>
            <p><?= $_SESSION['errors']['password'][0]; ?></p>
            <?php
            $_SESSION['errors']['password'] = null;
        }
        ?>
        <input type="password" name="password" placeholder="Новый пароль">
    </div>
    <div>
        <input type="password" name="password_confirm" placeholder="Подтвердите пароль">
    </div>
    <div>
        <input type="submit" value="Обновить">
    </div>
</form>


</body>
</html>

