<?php
/**
 * Created by PhpStorm.
 * User: rod
 * Date: 25.01.16
 * Time: 17:03
 */
require_once __DIR__ . '/app/init.php';
$data = isset($_POST['user']) ? $_POST['user'] : [];
$user = [];
$errors = [];
if (isset($data['id'])) {
    $id = $data['id'];
} else if (isset($_GET['id'])) {
    $id = $_GET['id'];
}
if (isset($id)) {
    $user = getUserById((int) $id);
    if (!$user) {
        header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not found');
        exit('Post not found');
    }
}
if ($data) {
    $user = saveUser($data, $errors);
    if (!$errors) {
        //Запись успешно сохарнена
        header('location: registration.php?id=' . $user['id']);
        exit;
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Blojjeq - Registration</title>
</head>
<body>
<form method="post">
    <div>
        <div class="error"><?= e($errors, 'username') ?></div>
        <label for="registration-username">Username</label>
        <input id="registration-username" name="user[username]" type="text" value="<?= e($user, 'username') ?>">
    </div>
    <div>
        <div class="error"><?= e($errors, 'email') ?></div>
        <label for="registration-email">Email</label>
        <input id="registration-email" name="user[email]" type="email" value="<?= e($user, 'email') ?>">
    </div>
    <div>
        <div class="error"><?= e($errors, 'password') ?></div>
        <label for="registration-pass">Password</label>
        <input id="registration-pass" name="user[password]" type="password" value="<?= e($user, 'password') ?>">
    </div>
    <div>
        <div class="error"><?= e($errors, 'verification') ?></div>
        <label for="registration-verification">Password verification</label>
        <input id="registration-verification" name="user[verification]" type="password" value="<?= e($user, 'verification') ?>">
    </div>

    <?php  if (isset($user['id'])): ?>
        <div>
            <input type="hidden" name="user[id]" value="<?= e($user, 'id') ?>">
        </div>
    <?php endif; ?>
    <div>
        <input type="submit">
    </div>
</form>
</body>
</html>