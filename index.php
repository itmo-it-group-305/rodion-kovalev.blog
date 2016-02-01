<?php
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

var_dump($uri);

var_dump(
    parse_url('http://ya.ru/post/123?id=1#hash', PHP_URL_QUERY));