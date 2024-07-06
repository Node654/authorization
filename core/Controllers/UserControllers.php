<?php

namespace Auth\Controllers;

use Auth\Service\User\User;
use Auth\Validator\Validator;

class UserControllers
{
    public static function showRegisterForm()
    {
        if (isset($_SESSION['auth'])) {
            header('Location: /');
            die;
        }
        require_once PAGES . '/registerForm.php';
    }

    public static function register()
    {
        $name = $_POST['name'];
        $tel = $_POST['phone'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $password_confirm = $_POST['password_confirm'];
        $data = [
            'name' => $name,
            'phone' => $tel,
            'email' => $email,
            'password' => $password,
            'password_confirm' => $password_confirm
        ];
        $errors = Validator::validate([
            'name' => 'required|min:1|max:20|string',
            'email' => 'required|email|unique:users',
            'phone' => 'required|string|unique:users|tel',
            'password' => 'required|min:1|max:255|string|confirmed',
        ], $data);

        if (! empty($errors)) {
            $_SESSION['errors'] = $errors;
            header('Location: /register');
        } else {
            User::insert('users', [
                'name' => $name,
                'phone' => $tel,
                'email' => $email,
                'password' => $password
            ]);
            $_SESSION['registerSuccess'] = 'Вы успешно зарегистрировались, можете войти!';
            header('Location: /login');
        }
        die;
    }

    public static function showLoginForm()
    {
        if (isset($_SESSION['auth'])) {
            header('Location: /');
            die;
        }
        require_once PAGES . '/loginForm.php';
    }

    public static function login()
    {
        # Тут нужен второй секретный ключ для обмена между гуглом и сайтом
        $recaptchaSecret = '#';
        $recaptchaResponse = $_POST['g-recaptcha-response'];
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query(array(
            'secret' => $recaptchaSecret,
            'response' => $recaptchaResponse
        )));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($curl);
        curl_close($curl);
        $responseData = json_decode($response);

        if (! $responseData->success) {
            $_SESSION['recaptchaError'] = 'Вы не прошли проверку!';
            header('Location: /login');
            die;
        }

        $emailOrPhone = $_POST['emailOrPhone'];
        $password = $_POST['password'];
        $errorLogin = Validator::loginValidate($emailOrPhone, $password);

        if (! empty($errorLogin)) {
            $_SESSION['errorLogin'] = $errorLogin;
            header('Location: /login');
            die;
        } else {
            $user = User::getUserByEmailOrPhone($emailOrPhone);
            $_SESSION['loginSuccess'] = 'Вы успешно вошли в аккаунт!';
            $_SESSION['auth'] = true;
            $_SESSION['idUser'] = $user->id;
            header("Location: /profile/{$user->id}");
            die;
        }
    }

    public static function show(int $id)
    {
        User::checkedUser();
        extract(['user' => User::select('users', ['id' => $id])]);
        require_once PAGES . '/profile.php';
    }

    public static function logout()
    {
        $_SESSION['auth'] = false;
        $_SESSION['idUser'] = null;
        session_destroy();
        header('Location: /');
        die;
    }

    public static function update(int $id)
    {
        User::checkedUser();
        extract(['user' => User::select('users', ['id' => $id])]);
        require_once PAGES . '/updateForm.php';
    }

    public static function edit()
    {
        $id = (int) $_POST['id'];
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $password_confirm = $_POST['password_confirm'];
        $errors = Validator::validate([
            'name' => 'required|min:1|max:20|string',
            'email' => 'required|email',
            'phone' => 'required|string|tel',
            'password' => 'required|min:1|max:255|string|confirmed',
        ], [
            'name' => $name,
            'phone' => $phone,
            'email' => $email,
            'password' => $password,
            'password_confirm' => $password_confirm
        ]);
        if (! empty($errors)) {
            $_SESSION['errors'] = $errors;
            header('Location: /update/' . $id);
        } else {
            User::update('users', ['id' => $id, 'name' => $name, 'phone' => $phone, 'email' => $email, 'password' => $password]);
            header('Location: /profile/' . $id);
        }
        die;
    }
}