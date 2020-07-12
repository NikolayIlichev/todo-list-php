<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <?php addHeaderStyles();?>
    <title>TODO List</title>
</head>
<body>

<h1 class="page_title">Добавление задачи</h1>
<div class="link_wrap">

    <?php if ($_SESSION['is_admin']): ?>
        <a class="link" href="?logout=yes">Закончить сеанс администратора</a>
    <?php else: ?>
        <a class="link" href="/admin/">Вход для администратора</a>
    <?php endif; ?>

    <a class="link" href="/">К списку задач</a>
</div>
<div class="add_task_form">

    <?php if (!empty($data['msg'])): ?>
        <?php foreach ($data['msg'] as $msg): ?>
            <span class="status_message"><?php echo $msg; ?></span>
        <?php endforeach; ?>
    <?php endif; ?>

    <form action="" method="POST">
        <div class="form-group">
            <label for="name">Ваше имя</label>
            <input class="form-control" id="name" placeholder="Ваше имя" type="text" name="user_name" value="<?php echo isset($_POST['user_name']) ? $_POST['user_name'] : ''; ?>">
        </div>
        <div class="form-group">
            <label for="email">Ваш email</label>
            <input class="form-control" id="email" placeholder="Ваш email" type="text" name="user_email" value="<?php echo isset($_POST['user_email']) ? $_POST['user_email'] : ''; ?>">
        </div>
        <div class="form-group">
            <label for="text">Текст</label>
            <textarea class="form-control" id="text" name="text" maxlength="500" rows="5"><?php echo isset($_POST['text']) ? $_POST['text'] : ''; ?></textarea>
        </div>
        <input type="submit" name="add_task" value="Добавить задачу">
    </form>
</div>

</body>
</html>