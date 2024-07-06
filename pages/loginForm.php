<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Форма авторизации</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
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
        .auth-form {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .auth-form h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            color: #666;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }
        .form-group input:focus {
            outline: none;
            border-color: #007bff;
        }
        .auth-form button {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: white;
            cursor: pointer;
        }
        .auth-form button:hover {
            background-color: #0056b3;
        }

        #emailOrPhone {
            width: 300px;
        }
    </style>
</head>
<body>
<div class="auth-form">
    <?php if (isset($_SESSION['registerSuccess'])) { ?>
        <h2><?= $_SESSION['registerSuccess'] ?></h2>
    <?php unset($_SESSION['registerSuccess']); } ?>
    <h2>Авторизация</h2>
    <form id="feedBackForm" action="/login" method="post">
        <div class="form-group">
            <?php if (isset($_SESSION['errorLogin']['emailOrPhoneLoginError'])) { ?>
                <h3><?= $_SESSION['errorLogin']['emailOrPhoneLoginError']; ?></h3>
            <?php unset($_SESSION['errorLogin']['emailOrPhoneLoginError']); } ?>
            <label for="emailOrPhone">Email или телефон</label>
            <input type="text" id="emailOrPhone" name="emailOrPhone" required placeholder="example@mail.ru или +79123456789">
        </div>
        <div class="form-group">
            <?php if (isset($_SESSION['errorLogin']['emailOrPhonePasswordError'])) { ?>
                <h3><?= $_SESSION['errorLogin']['emailOrPhonePasswordError']; ?></h3>
            <?php unset($_SESSION['errorLogin']['emailOrPhonePasswordError']); } ?>
            <label for="password">Пароль</label>
            <input type="password" id="password" name="password" required>
        </div>
        <div class="form-group">
            <?php if (isset($_SESSION['recaptchaError'])) { ?>
                <h3><?= $_SESSION['recaptchaError']; ?></h3>
            <?php unset($_SESSION['recaptchaError']);} ?>
        </div>
        <!-- Нужно подключить ключ google captcha -->
        <div class="g-recaptcha" data-sitekey="#"></div>
        <div class="text-danget" id="recaptchaError"></div>
        <button type="submit">Войти</button>
    </form>
</div>
</body>
</html>


