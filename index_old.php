<?php
//var_dump(__DIR__ . '/app/models/post.php');

require_once __DIR__ . '/app/init.php'; //require once поделючает файл. а __DIR__ возврашает путь где лежит сейчас файлик index_old.php с помощью __DIR__

$posts = getAllPosts();
//var_dump(
//    storageSaveItem('post', ['title' => 'post#1', 'content' => 'first'])
//)

require_once __DIR__ . '/app/views/list.php';
