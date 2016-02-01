<?php
/**
 * Created by PhpStorm.
 * User: rod
 * Date: 25.01.16
 * Time: 16:59
 */
require_once __DIR__ . '/libs/storage.php';
require_once __DIR__ . '/libs/view.php';
require_once __DIR__ . '/app/models/post.php';
require_once __DIR__ . '/app/models/user.php';
$some = $_POST['some'];

$id = $some['id'];

$requiredUser = getUserById($id);

var_dump($requiredUser);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<form method="post">
    <h2>Enter ID and take your user! bitch...</h2>
    <label for="get-user">ID</label>
    <input id="get-user" name="some[id]" type="text" >
    <input type="submit">
</form>
<?php if (isset($some['id'])): ?>

    <h3>Username:
        <?= $requiredUser['username'] ?>
    </h3>
    <h3>Email:
        <?= $requiredUser['email'] ?>
    </h3>
    <h3>Created:
        <?= date('Y-m-d H:i', $requiredUser['created']) ?>
    </h3>
    <h3>Updated:
        <?= date('Y-m-d H:i', $requiredUser['updated']) ?>
    </h3>

<?php endif; ?>
</body>
</html>