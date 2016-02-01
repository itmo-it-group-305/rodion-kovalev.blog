<?php
const ENTITY_POST = 'post';
/**
 * @return array|bool возвращает все записи в блоге, имеющиеся на текущий момент.
 */
function getAllPosts()
{
    $posts = storageGetAll(ENTITY_POST);
    uasort($posts, function ($a, $b) {
        $d1 = $a['created'];
        $d2 = $b['created'];
        if ($d1 == $d2) {
            return 0;
        }
        return ($d1 > $d2) ? -1 : 1;
    });
    return $posts;
}
/**
 * @param int $id уникальный идентификатор записи.
 * @return array|null возвращает запись в блоге по идентификатору.
 */
function getPostById($id)
{
    return storageGetItemById(ENTITY_POST, (int) $id);
}
/**
 * Добавляет или обновляет информацию о записи в блоге.
 *
 * @param array $data данные.
 * @param array $errors ошибки, возникшие в ходе выполнения операции.
 * @return array|bool возвращает обновленную запись блога или false в случаи критической ошибки.
 */
function savePost(array $data, array &$errors = null)
{
    $id = isset($data['id']) ? (int) $data['id'] : null;
    $post = sanitize($data, postSanitizeRules(), $errors); // тут будет присвоен результат валидации и очистки
    if ($errors) {
        return $post;
    }
    $post['updated'] = mktime();
    if (!$id) {
        $post['created'] = mktime();
    }
    $status = storageSaveItem(ENTITY_POST, $post);
    if (!$status) {
        $errors['db'] = 'Не удалось записать данные в базу';
    }
    return $post;
}

function postSanitizeRules()
{
    return [
        'title'=> [
            'required'=>true,
            'filter'=>FILTER_SANITIZE_SPECIAL_CHARS,
    ],
        'content'=>[
            'required'=> true,
            'filter'=> FILTER_SANITIZE_FULL_SPECIAL_CHARS,

            ],
    ];
}