<?php


$res = filter_var('123', FILTER_VALIDATE_INT, [
    'options' => [
        'min_range' =>-10,
        'max_range'=>10,
    ],
    'flags' => FILTER_NULL_ON_FAILURE,
]);

var_dump($res);