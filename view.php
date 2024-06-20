<?php
// Подключение к БД
require 'reg\connect.php';

// Получение ID статьи из GET-запроса
$id = $_GET['id'];

// Запрос на получение статьи по ID
$sql = "SELECT * FROM post WHERE id = :id";
$statement = $pdo->prepare($sql);
$statement->execute(['id' => $id]);

// Получение статьи
$post = $statement->fetch(PDO::FETCH_ASSOC);

if (!$post) {
    echo "Статья не найдена!";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?php echo htmlspecialchars($post['title']) ?></title>
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
                <h2><?php echo htmlspecialchars($post['title']) ?></h2>
            </div>
            <div class="panel-container show">
                <div class="panel-content">
                    <p><?php echo htmlspecialchars($post['content']) ?></p>
                    <a href="index.php" class="btn btn-secondary">Назад</a>
                </div>
            </div>
        </div>
    </div>
</main>
</body>
</html>
