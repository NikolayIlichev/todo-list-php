<?php

require_once 'model/UserModel.php';

class UserController
{

    public static function login($postData)
    {
        if (!empty($postData['login']) && !empty($postData['password'])) {
            $msg = [];
            $login = strip_tags(trim($postData['login']));
            $password = strip_tags(trim($postData['password']));
            $arUser = UserModel::login($login);
            if (!empty($arUser[0]) && !password_verify($password, $arUser[0]['password'])) {
                $msg[] = 'Неверный пароль!';
            }
            elseif (empty($arUser[0])) {
                $msg[] = 'Пользователь с таким логином не найден!';
            }
            else {
                $_SESSION['is_admin'] = true;
                $msg[] = 'Успешная авторизация';
            }
        }
        else {
            if (empty($postData['login'])) {
                $msg[] = 'Логин не заполнен';
            }
            if (empty($postData['password'])) {
                $msg[] = 'Пароль не заполнен';
            }
        }

        $data = ['msg' => $msg];
        render('admin', $data);
    }

    public static function logout()
    {
        unset($_SESSION['is_admin']);
    }
}