<?php
session_start();

require_once 'controller/TaskController.php';
require_once 'controller/UserController.php';

$curDir = getCurDir();

if (!empty($_GET['logout'])) {
    UserController::logout();
}

if ($curDir === '/') {
    if (!empty($_POST['edit_text'])) {
        TaskController::editText($_POST);
    } else if (!empty($_POST['edit_status'])) {
        TaskController::editStatus($_POST);
    } else {
        TaskController::getList();
    }
} elseif ($curDir === '/admin/') {
    if (!empty($_POST['auth'])) {
        UserController::login($_POST);
    } else {
        render('admin');
    }
} elseif ($curDir === '/add/') {
    if (!empty($_POST['add_task'])) {
        TaskController::add($_POST);
    } else {
        render('add');
    }
} else {
    render('404');
}