<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">

    <title><?= $post['title'] ?></title>



</head>
<body>
<h1><?= $post['title'] ?></h1>

<p>Создано <?= date ('Y-m-d H:i', $post['created']) ?></p>


<p>Обновлено<?= date ('Y-m-d H:i', $post['updated']) ?></p>
<?= $post['content'] ?>
</body>
</html>

require_once __DIR__ . '/app/init.php';