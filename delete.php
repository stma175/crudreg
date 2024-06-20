<?php
// Подключение к БД
require 'reg\connect.php';

// Получение ID статьи из GET-запроса
$id = $_GET['id'];

// Удаление статьи из БД
$sql = "DELETE FROM post WHERE id = :id";
$statement = $pdo->prepare($sql);
$statement->execute(['id' => $id]);

// Перенаправление на главную страницу
header('Location: index.php');
exit;
?>