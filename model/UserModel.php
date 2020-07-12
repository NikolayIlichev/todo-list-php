<?php

class UserModel
{
    public static function login($login)
    {
        $db = db();
        $sql = "SELECT login, password FROM users WHERE login=:login";
        $stmt = $db->prepare($sql);
        $stmt->execute(['login' => $login]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}