<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <?php addHeaderStyles();?>
    <title>TODO List</title>
</head>
<body>
<h1 class="page_title">Вход для администратора</h1>
<div class="link_wrap">

    <?php if ($_SESSION['is_admin']): ?>
        <a class="link" href="?logout=yes">Закончить сеанс администратора</a>
    <?php else: ?>
    <?php endif; ?>

    <a class="link" href="/add/">Добавить задачу</a>
    <a class="link" href="/">К списку задач</a>
</div>

<?php if ($_SESSION['is_admin']): ?>
    <span class="auth_status">Вы авторизованы.</span>
<?php else: ?>
<div class="add_task_form">

    <?php if (!empty($data['msg'])): ?>
        <?php foreach ($data['msg'] as $msg): ?>
            <span class="status_message"><?php echo $msg; ?></span>
        <?php endforeach; ?>
    <?php endif; ?>

    <form action="" method="POST">
        <div class="form-group">
            <label for="login">Логин</label>
            <input class="form-control" id="login" placeholder="Логин" type="text" name="login" value="<?php echo isset($_POST['login']) ? $_POST['login'] : ''; ?>">
        </div>
        <div class="form-group">
            <label for="password">Пароль</label>
            <input class="form-control" id="password" placeholder="Ваш email" type="password" name="password" value="<?php echo isset($_POST['password']) ? $_POST['password'] : ''; ?>">
        </div>
        <input type="submit" name="auth" value="Авторизоваться">
    </form>
</div>
<?php endif; ?>



</body>
</html>