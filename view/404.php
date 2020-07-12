<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <?php addHeaderStyles();?>
    <title>404 error</title>
</head>
<body>
<h1 class="page_title">Страницы с таким адресов не существует</h1>
<div class="link_wrap">

    <?php if ($_SESSION['is_admin']): ?>
        <a class="link" href="?logout=yes">Закончить сеанс администратора</a>
    <?php else: ?>
        <a class="link" href="/admin/">Вход для администратора</a>
    <?php endif; ?>

    <a class="link" href="/">К списку задач</a>
    <a class="link" href="/add/">Добавить задачу</a>
</div>
</body>
</html>