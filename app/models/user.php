<?php
const ENTITY_USER = 'user';

function getUserBy($attribute, $value)
{
    return storageGetItemBy(ENTITY_USER, $attribute, $value);
}//нужно посмотреть есть ли  массива такой ключ(аттрибут)

function getAllUsers()
{
return storageGetAll(ENTITY_USER);
}
function getUserById($id)
{
return storageGetItemByID(ENTITY_USER, $id);
}

function saveUser($data, &$errors = null)
{
$id = isset($data['id']) ? $data['id'] : null;

$user = $data;

if ($errors) {

var_dump($user . ' error');

return $user;
}

$user['updated'] = mktime();

if (!$id) {

$user['created'] = mktime();
}

$status = storageSaveItem(ENTITY_USER, $user);
if (!$status) {

$errors['db'] = 'Не удалось записать данные в базу';
}
var_dump($user . ' its okay');

return $user;
}