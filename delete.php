<?php
require 'reg\connect.php';

$id = $_GET['id'];

$sql = "DELETE FROM post WHERE id = :id";
$statement = $pdo->prepare($sql);
$statement->execute(['id' => $id]);

header('Location: index.php');
exit;
