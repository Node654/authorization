<?php

namespace Auth\Validator;

use Auth\Database\Database;
use Auth\Service\User\User;

class Validator
{
    private static $errors = [];
    private static $errorsLogin = [];

    public static function validate(array $rules, array $data)
    {
        foreach ($rules as $field => $ruleSet) {
            $rulesArray = explode('|', $ruleSet);
            foreach ($rulesArray as $rule) {
                if (strpos($rule, ':')) {
                    list($ruleName, $ruleValue) = explode(':', $rule);
                } else {
                    $ruleName = $rule;
                    $ruleValue = '';
                }

                switch ($ruleName) {
                    case 'required':
                        if (empty($data[$field])) {
                            self::$errors[$field][] = "Поле {$field} обязательно для заполнения.";
                        }
                        break;
                    case 'min':
                        if (strlen($data[$field]) < $ruleValue) {
                            self::$errors[$field][] = "Поле {$field} должно быть не менее {$ruleValue} символов.";
                        }
                        break;
                    case 'max':
                        if (strlen($data[$field]) > $ruleValue) {
                            self::$errors[$field][] = "Поле {$field} не должно превышать {$ruleValue} символов.";
                        }
                        break;
                    case 'string':
                        if (!is_string($data[$field])) {
                            self::$errors[$field][] = "Поле {$field} должно быть строкой.";
                        }
                        break;
                    case 'unique':
                         if (! User::exists($ruleValue, $field, $data[$field])) {
                             self::$errors[$field][] = "Значение поля {$field} уже существует.";
                         }
                        break;
                    case 'email':
                        if (!filter_var($data[$field], FILTER_VALIDATE_EMAIL)) {
                            self::$errors[$field][] = "Поле {$field} должно быть действительным адресом электронной почты.";
                        }
                        break;
                    case 'tel':
                        $pattern = '/^\+?[0-9]{1,3}?[-.\s]?\(?[0-9]{2,3}?\)?[-.\s]?[0-9]{3}[-.\s]?[0-9]{4,6}$/';
                        if (!preg_match($pattern, $data[$field])) {
                            self::$errors[$field][] = "Поле {$field} должно соответствовать международному формату номера телефона.";
                        }
                        break;
                    case 'confirmed':
                        if ($data[$field] !== $data[$field . '_confirm']) {
                            self::$errors[$field][] = "Поле {$field} не совпадает с подтверждением.";
                        }
                        break;
                }
            }
        }
        return self::$errors;
    }

    public static function loginValidate($emailOrPhone, $password) {
        if (filter_var($emailOrPhone, FILTER_VALIDATE_EMAIL)) {
            if (User::checkEmailExists($emailOrPhone)) {
                if (User::validatePasswordByEmail($emailOrPhone, $password)) {
                    return self::$errorsLogin;
                } else {
                    self::$errorsLogin['emailOrPhonePasswordError'] = 'Неверный пароль для данного email.';
                }
            } else {
                self::$errorsLogin['emailOrPhoneLoginError'] = 'Email не найден.';
            }
            return self::$errorsLogin;
        } elseif (preg_match('/^\+\d{1,3}\d{1,14}(?:x.+)?$/', $emailOrPhone)) {
            if (User::checkPhoneExists($emailOrPhone)) {
                if (User::validatePasswordByPhone($emailOrPhone, $password)) {
                    return self::$errorsLogin;
                } else {
                    self::$errorsLogin['emailOrPhonePasswordError'] = "Неверный пароль для данного телефона.";
                }
            } else {
                self::$errorsLogin['emailOrPhoneLoginError'] = "Телефон не найден.";
            }
            return self::$errorsLogin;
        } else {
            return "Введенные данные не соответствуют форматам email или телефона.";
        }
    }
}