<?php
require_once __DIR__ . '/app/init.php';

$post = getPostById(
    isset ($_GET['id']) ? $_GET['id'] : ''
);

if(!$post) {
    header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not found'); //под сервер протокол лежит адрес. то есть написано будет "адрес" не найден"
    exit('Post not found!');
}

//var_dump($post);

require_once __DIR__ . '/app/views/show.php';
