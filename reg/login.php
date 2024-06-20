<?php
session_start();
require_once 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = $_POST['login'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE login = :login");
    $stmt->execute(['login' => $login]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = $user;
        $_SESSION['message'] = 'Вы успешно вошли в систему!!!';
        header('Location: ../index.php');
    } else {
        $_SESSION['message'] = 'Неправильный логин или пароль!!!';
        header('Location: login.php');
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="main.css">
    <title>Авторизация</title>
</head>
<body>
  <center>
    <h2>Авторизация</h2>
    <?php if (isset($_SESSION['message'])): ?>
        <p><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></p>
    <?php endif; ?>
    <form action="login.php" method="post">

    </center>
    <fieldset>
    <label>Логин</label>
        <input type="text" name="login" placeholder="Логин" required>
        <label>Пароль</label>
        <input type="password" name="password" placeholder="Пароль" required>
        
        <button type="submit">Войти</button>
        <p>
        Нет аккаунта? - <a href="register.php">Зарегистрироваться</a>
    </p>
        <p><a href="../index.php">к постам</a></p>
    </fieldset>
</form>
</body>
</html>







