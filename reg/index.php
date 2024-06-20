<!--
1. Подготовить хранилище (массив, а потом подключимся к БД)
2. вывести список данных через foreach

1. Подключится к БД +
2. Сделать запрос select+
3. Получить результат
4. Передать данные в переменную $posts

-->
<?php
session_start();
// Подключение к БД
require 'reg\connect.php';

// Запрос на получение всех статей
$sql = "SELECT * FROM post";
$statement = $pdo->prepare($sql);
$statement->execute();

// Получение результата
$posts = $statement->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Изучение CRUD</title>
    <meta name="description" content="CRUD Operations">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no, minimal-ui">
    <link id="vendorsbundle" rel="stylesheet" media="screen, print" href="css/vendors.bundle.css">
    <link id="appbundle" rel="stylesheet" media="screen, print" href="css/app.bundle.css">
    <link id="myskin" rel="stylesheet" media="screen, print" href="css/skins/skin-master.css">
</head>
<body class="mod-bg-1 mod-nav-link ">
<main id="js-page-content" role="main" class="page-content">
    <div class="col-md-6">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>Список статей</h2>
            </div>
            <div class="panel-container show">
                <div class="panel-content">
                    <div class="fs-lg fw-300 p-5 bg-white border-faded rounded mb-g">
                        <?php foreach ($posts as $post): ?>
                            <h3><?php echo htmlspecialchars($post['title']) ?></h3>
                            <p><?php echo htmlspecialchars($post['content']) ?></p>
                            <a href="view.php?id=<?php echo $post['id'] ?>" class="btn btn-info">Просмотр</a>
                            <?php if (isset($_SESSION['user'])): ?>
                                <a href="edit.php?id=<?php echo $post['id'] ?>" class="btn btn-warning">Редактирование</a>
                                <a href="delete.php?id=<?php echo $post['id'] ?>" class="btn btn-danger" onclick="return confirm('Вы уверены?')">Удаление</a>
                            <?php endif; ?>
                            <br><br>
                        <?php endforeach; ?>
                    </div>
                    <?php if (isset($_SESSION['user'])): ?>
                        <a href="create.php" class="btn btn-success">Добавить статью</a>
                        <a href="reg\logout.php" class="btn btn-danger">Выход</a>
                    <?php else: ?>
                        <a href="reg\login.php" class="btn btn-primary">Авторизация</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</main>
</body>
</html>