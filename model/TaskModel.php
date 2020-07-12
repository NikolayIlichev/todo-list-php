<?php

class TaskModel
{
    private static $taskPerPage = 3;

    public static function getList($page, $sortType, $sortDirection)
    {
        $orderBy = '';
        if (!empty($sortType) && !empty($sortDirection)) {
            $orderBy = " ORDER BY " . $sortType . " " . $sortDirection;
        }
        $db = db();
        $sql = "SELECT id, user_name, user_email, text, status, edited FROM tasks" . $orderBy . " LIMIT :from, :to";
        $stmt = $db->prepare($sql);
        $stmt->execute(['from' => $page * self::$taskPerPage - self::$taskPerPage, 'to' => $page * self::$taskPerPage]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getCount()
    {
        $db = db();
        $sql = "SELECT COUNT(id) as count FROM tasks";
        $stmt = $db->query($sql);
        return $stmt->fetchColumn();
    }

    public static function add($name, $email, $text)
    {
        $db = db();
        $sql = "INSERT INTO tasks(user_name, user_email, text, status) VALUES(:name, :email, :text, 'N')";
        $stmt = $db->prepare($sql);
        $stmt->execute(['name' => $name, 'email' => $email, "text" => $text]);
    }

    public static function editText($id, $text)
    {
        $db = db();
        $sql = "UPDATE tasks SET text=:text, edited='Y' WHERE id=:id";
        $stmt = $db->prepare($sql);
        $stmt->execute(['id' => $id, "text" => $text]);
    }

    public static function editStatus($id, $status)
    {
        $db = db();
        $sql = "UPDATE tasks SET status=:status WHERE id=:id";
        $stmt = $db->prepare($sql);
        $stmt->execute(['id' => $id, "status" => $status]);
    }
}