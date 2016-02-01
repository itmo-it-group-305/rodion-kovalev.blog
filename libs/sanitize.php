<?php
    function sanitize(array $data, array $rules, array &$errors = null) //синоним Валидации почти
    {
        $errors = is_array($errors) ? $errors : [];//если приходит не массив, то превратить в массив

        //1. этап - подготовка правил валидации / фильтрации

        foreach ($rules as $attribute => $rule)
        {
            $rule['flags'] = isset($rule['flags'])
            ?    $rule['flags'] | FILTER_NULL_ON_FAILURE//если флаг был передан, то не стираем а складываем их
            :    FILTER_NULL_ON_FAILURE;

            $rule['required'] = isset($rule['required'])// проверяем, чтобы обяхательно форма была заполнена
                ? (bool) $rule ['required']
                : false;
            $rule['message'] = isset($rule['message'])
                ? $rule['message']
                : '';
            $rules[$attribute]=$rule;
        }
        //var_dump($rules);

        //2. этап - непосредственно валидации / фильтрации
        $data = array_map('trim', $data);
        $filterData = filter_var_array($data, $rules);

        foreach ($filterData as $attribute =>$value) {
            $rule = $rules[$attribute];

            if (is_null($value)) {
                if ($data[$attribute] || ($data[$attribute] === '' && $rule['required'])) {
                    sanitizeAddError(
                        $attribute,
                        $rule['message'] ?: 'Некорректное значение в поле {attribute}',
                        $errors

                    );
                }
            }
            if (is_string($value)) {
                $value = trim($value);//обрезаем пробелы,если есть лишние

                $filterData[$attribute] = $value;

                if (!$value && $rule['required']) {
                    sanitizeAddError(
                        $attribute,
                        $rule['message'] ? : 'Не заполнено обязательное поле {attribute}',
                        $errors
                    );
                }
            }
        }


        return $filterData;
    }

    function sanitizeAddError($attribute, $message, array &$errors) //будет добавлять ошибку в $error
    {//некорректное значение в поле '{attribute}'
        $errors[$attribute] = strtr($message, [
            '{attribute}' => $attribute,]);
    }

$data = [
    'username' => 'Pofiks',
    'password' => 'BAGU!!!',

];

$rules = [
    'username' => [
        'required' => true,
        'filter' => FILTER_VALIDATE_REGEXP,
        'options'=>[
        'regexp' => '`^[a-z0-9_-]{4,}$`i',
        ],
        'message' => 'Имя пользователя должно быть более 4-х символов и содерджать что-нибуд',

    ],
    'password' => [
        'required'=>true,
        'filter' => FILTER_VALIDATE_REGEXP,
        'options'=>[
        'regexp' => '`^[^\s]{4,}$`i',
    ],
        'message' => 'Имя пользователя должно быть более 4-х символов и содерджать что-нибуд'
    ],
];

$errors = [];

var_dump(
    sanitize($data,$rules, $errors),
    $errors
);

//0111101101=>unix/linux права доступа

//-rwxrwxrwx -read,write,execute

//Author Group Other

//mkdir('', 0755);
//1 & 10 = 11

//В PHP доступна мощная программа фильтрации. сложные проверки нужно делать с помощью регулярок, а более или менее простые
//их нужно с помощью готовых фильтров делать. При этом изначально сами фильтры имеют функцию, которая позволяет очистить
//те данные, которые введены в форму