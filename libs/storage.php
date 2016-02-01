<?php
/**
* Путь к директории, в которой будут сохранены все файлы сущностей.
*/
const DB_DIR = 'db';
/**
* @param string $entity имя сущности.
* @param int $id уникальный идентификатор сущности.
* @return string возвращает имя файла сущности.
*/
function storageCreateFilenameItem($entity, $id)
{
return DB_DIR . DIRECTORY_SEPARATOR . sprintf(storageGetFilenamePattern($entity), $id);
}
/**
* @param string $entity имя сущности.
* @return string возвращает шаблон имени файла сущности.
*/
function storageGetFilenamePattern($entity)
{
return $entity . '_%d.json';
}
/**
* @param string $entity имя сущности.
* @return array возвращает все сохраненные сущности из хранилища.
*/
function storageGetAll($entity)
{
$posts = [];
$dir = opendir(DB_DIR);
do {
$filename = readdir($dir);
list($id) = sscanf($filename, storageGetFilenamePattern($entity));
if ($id) {
$posts[] = storageGetItemById($entity, $id);
}
} while ($filename);
closedir($dir);
return $posts;
}
/**
* @param string $entity имя сущности.
* @param int $id уникальный идентификатор сущности.
* @return array|null возвращает сущность с указанным идентификатором или null в случаи отсутствия.
*/
function storageGetItemById($entity, $id)
{
$filename = storageCreateFilenameItem($entity, $id);
if (is_readable($filename)) {
return json_decode(
file_get_contents($filename), true
);
}
return null;
}
/**
* @param string $entity имя сущности.
* @param array $item сущность.
* @return bool статус выполнения операции.
*/
function storageSaveItem($entity, array &$item)
{
$id = isset($item['id']) ? $item['id'] : 0;
$storedItem = storageGetItemById($entity, (int) $id) ?: [];
if ($id && !$storedItem) {
return false;
}
$item = array_merge($storedItem, $item);
if (!$id) {
$items = storageGetAll($entity);
foreach ($items as $storedItem) {
if ($storedItem['id'] > $id) {
$id = $storedItem['id'];
}
}
$id += 1;
}
$item['id'] = (int) $id;
$filename = storageCreateFilenameItem($entity, $id);
$status = file_put_contents(
$filename, json_encode($item), LOCK_EX
);
return (bool) $status;
}