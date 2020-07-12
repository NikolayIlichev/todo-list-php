<?php

require_once 'model/TaskModel.php';

class TaskController
{

    public static function getList()
    {
        $sortType = '';
        $sortDirection = '';
        $page = 1;

        if (!empty($_GET['page'])) {
            $page = intval($_GET['page']);
        }

        if (!empty($_POST['sort']) && $_POST['sort'] === 'default') {
            unset($_SESSION['sort']);
        } elseif (!empty($_POST['sort'])) {
            $sortData = explode(':', strip_tags(trim($_POST['sort'])));
            $sortType = $sortData[0];
            $sortDirection = $sortData[1];

            $_SESSION['sort']['type'] = $sortType;
            $_SESSION['sort']['direction'] = $sortDirection;
        } elseif (!empty($_SESSION['sort'])) {
            $sortType = $_SESSION['sort']['type'];
            $sortDirection = $_SESSION['sort']['direction'];
        }

        $arTasks = TaskModel::getList($page, $sortType, $sortDirection);
        $count = TaskModel::getCount();
        $data = ["tasks" => $arTasks, 'count' => $count, 'page' => $page];

        render('index', $data);
    }

    public static function add($postData)
    {
        $name = strip_tags(trim($postData['user_name']));
        $email = strip_tags(trim($postData['user_email']));
        $text = strip_tags(trim($postData['text']));

        $msg = [];
        if (empty($name)) {
            $msg[] = 'Незаполнено имя';
        }

        if (empty($email)) {
            $msg[] = 'Незаполнен email';
        } else {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $msg[] = 'Некорректный email';
            }
        }

        if (empty($text)) {
            $msg[] = 'Незаполнено описание задачи';
        }

        if (empty($msg)) {
            TaskModel::add($name, $email, $text);
            $msg[] = 'Задача добавлена!';
        }

        render('add', ['msg' => $msg]);
    }

    public static function editText($postData)
    {
        if (empty($_SESSION['is_admin'])) {
            render('admin');
        } else {
            $id = strip_tags(trim($postData['task_id']));
            $text = strip_tags(trim($postData['text']));

            TaskModel::editText($id, $text);
            TaskController::getList();
        }
    }

    public static function editStatus($postData)
    {
        if (empty($_SESSION['is_admin'])) {
            render('admin');
        } else {
            $id = strip_tags(trim($postData['task_id']));
            $status = strip_tags(trim($postData['status']));

            TaskModel::editStatus($id, $status);
            TaskController::getList();
        }
    }
}