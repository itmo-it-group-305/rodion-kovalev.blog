
<?php
require_once __DIR__ . '/app/init.php';


$data = isset($_POST['post']) ? $_POST['post'] : [];
$errors = [];
$post = [];
if (isset($data['id'])) {
    $id = $data['id'];
} else if (isset($_GET['id'])) {
    $id = $_GET['id'];
}
if (isset($id)) {
    $post = getPostById((int) $id);
    if (!$post) {
        header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
        exit('Post not found');
    }
}
if ($data) {
    $msg = 'Запись успешно ' . (isset($post['id']) ? 'обновлена' : 'добавлена');
    $post = savePost($data, $errors);
    if (!$errors) {
        addFlashMessages($msg);
        header('location: edit.php?id=' . $post['id']);
        exit;
    }
}
/*
 * Мы попадаем сюда в 4-х случаях:
 * 1) форма не была отправлена, id не найден => добавить новую запись
 * 2) форма не была отправлена, id найден    => вывести форму для редактирования существующей записи
 * 3) форма была отправлена,    id не найден => добавление новой записи, но введенные данные не корректны
 * 4) форма была отправлена,    id найден    => редактирование записи, но введенные данные не корректны
 */
var_dump($post, $errors);
require_once __DIR__ . '/app/views/edit.php';


