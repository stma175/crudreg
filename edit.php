<?php

require 'reg\connect.php';

$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];

    $sql = "UPDATE post SET title = :title, content = :content WHERE id = :id";
    $statement = $pdo->prepare($sql);
    $statement->execute(['title' => $title, 'content' => $content, 'id' => $id]);

    header('Location: index.php');
    exit;
}

$sql = "SELECT * FROM post WHERE id = :id";
$statement = $pdo->prepare($sql);
$statement->execute(['id' => $id]);

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
    <title>Редактирование статьи</title>
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
                <h2>Редактирование статьи</h2>
            </div>
            <div class="panel-container show">
                <div class="panel-content">
                    <form method="post">
                        <div class="form-group">
                            <label for="title">Заголовок</label>
                            <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($post['title']) ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="content">Содержимое</label>
                            <textarea class="form-control" id="content" name="content" rows="5" required><?php echo htmlspecialchars($post['content']) ?></textarea>
                        </div>
                        <button type="submit" class="btn btn-warning">Обновить статью</button>
                    </form>
                    <a href="index.php" class="btn btn-secondary">Назад</a>
                </div>
            </div>
        </div>
    </div>
</main>
</body>
</html>
