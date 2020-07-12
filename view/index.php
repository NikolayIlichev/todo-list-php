<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <?php addHeaderStyles();?>
    <title>TODO List</title>
</head>
<body>
<h1 class="page_title">Список задач</h1>
<div class="link_wrap">

    <?php if ($_SESSION['is_admin']): ?>
        <a class="link" href="?logout=yes">Закончить сеанс администратора</a>
    <?php else: ?>
        <a class="link" href="/admin/">Вход для администратора</a>
    <?php endif; ?>

    <a class="link" href="/add/">Добавить задачу</a>
</div>
<?php
$sortType = 'default';
$sortDirection = 'default';
if (!empty($_SESSION['sort'])) {
    $sortType = $_SESSION['sort']['type'];
    $sortDirection = $_SESSION['sort']['direction'];
}
?>
<div class="sort_wrap">
    <form action="" method="POST">
        <div class="form-group">
            <label for="sort">Сортировка</label>
            <select class="form-control" id="sort" name="sort">
                <option value="default" <?php echo ($sortType === 'default' && $sortDirection === 'default') ? 'selected' : ''; ?>>По умолчанию</option>
                <option value="user_name:ASC" <?php echo ($sortType === 'user_name' && $sortDirection === 'ASC') ? 'selected' : ''; ?>>По имени пользователя (по возрастанию)</option>
                <option value="user_name:DESC" <?php echo ($sortType === 'user_name' && $sortDirection === 'DESC') ? 'selected' : ''; ?>>По имени пользователя (по убыванию)</option>
                <option value="user_email:ASC" <?php echo ($sortType === 'user_email' && $sortDirection === 'ASC') ? 'selected' : ''; ?>>По email (по возрастанию)</option>
                <option value="user_email:DESC" <?php echo ($sortType === 'user_email' && $sortDirection === 'DESC') ? 'selected' : ''; ?>>По email (по убыванию)</option>
                <option value="status:ASC" <?php echo ($sortType === 'status' && $sortDirection === 'ASC') ? 'selected' : ''; ?>>По статусу (по возрастанию)</option>
                <option value="status:DESC" <?php echo ($sortType === 'status' && $sortDirection === 'DESC') ? 'selected' : ''; ?>>По статусу (по убыванию)</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Отсортировать</button>
    </form>
</div>
<div class="tasks_wrap">
    <?php if (!empty($data['tasks'])): ?>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Имя</th>
                <th scope="col">Email</th>
                <th scope="col">Задача</th>
                <th class="status" scope="col">Статус</th>
            </tr>
            </thead>
            <tbody>

            <?php foreach ($data['tasks'] as $key => $task): ?>
                <tr>
                    <th scope="row"><?php echo $task['id']; ?></th>
                    <td><?php echo $task['user_name']; ?></td>
                    <td><?php echo $task['user_email']; ?></td>
                    <td>
                        <?php if ($_SESSION['is_admin']): ?>
                        <form action="" method="POST">
                            <div class="form-group">
                                <input name="task_id" type="hidden" value="<?php echo $task['id']?>">
                                <textarea class="form-control" name="text" maxlength="500" rows="5"><?php echo $task['text']; ?></textarea>
                            </div>
                            <input type="submit" name="edit_text" value="Изменить описание">
                        </form>
                        <?php else: ?>
                        <?php echo $task['text']; ?>
                        <?php endif; ?>
                    </td>
                    <td class="status">
                        <?php if ($_SESSION['is_admin']): ?>
                            <form action="" method="POST">
                                <input name="task_id" type="hidden" value="<?php echo $task['id']?>">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="status" class="form-check-input" id="status" <?php echo $task['status'] == 'Y' ? 'checked' : ''; ?> value="<?php echo $task['status'] == 'Y' ? 'N' : 'Y'; ?>">
                                    <label class="form-check-label" for="status"><?php echo $task['status'] == 'Y' ? 'Выполнено' : 'Не выполнено'; ?></label>
                                </div>
                                <input type="submit" name="edit_status" value="Изменить статус">
                            </form>
                            <span class="edited"><?php echo $task['edited'] == 'Y' ? 'Отредактировано администратором' : ''; ?></span>
                        <?php else: ?>
                            <span class="status"><?php echo $task['status'] == 'Y' ? 'Выполнено' : 'Не выполнено'; ?></span>
                            <span class="edited"><?php echo $task['edited'] == 'Y' ? 'Отредактировано администратором' : ''; ?></span>
                        <?php endif; ?>

                    </td>
                </tr>
            <?php endforeach; ?>

            </tbody>
        </table>

        <?php if ($data['count'] > 3): ?>
            <?php echo getPagination($data['count'], $data['page'],3); ?>
        <?php endif; ?>

    <?php else: ?>
        <span class="one_line_text">Пока нет ни одной задачи</span>
        <a href="/add/">Добавить</a>
    <?php endif; ?>
</div>


</body>
</html>