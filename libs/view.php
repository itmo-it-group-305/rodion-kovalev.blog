<?php
/**
 * Тип сообщения - ошибка.
 */
const MSG_TYPE_ERROR = 'error';
/**
 * Тип сообщения - успешно.
 */
const MSG_TYPE_SUCCESS = 'success';
/**
 * Добавляет новое всплывающее сообщение в очередь.
 *
 * @param string|array $messages одно или более сообщение.
 * @param string $type тип сообщения.
 */
function addFlashMessages($messages, $type = MSG_TYPE_SUCCESS) {
    if (!isset($_SESSION['messages'])) {
        $_SESSION['messages'] = [];
    }
    if (!isset($_SESSION['messages'][$type])) {
        $_SESSION['messages'][$type] = [];
    }
    is_array($messages)
        ? $_SESSION['messages'][$type] = array_merge($_SESSION['messages'][$type], $messages)
        : $_SESSION['messages'][$type][] = $messages;
}
function e(array $arr, $key, $default = '')
{
    return htmlspecialchars(
        p($arr, $key, $default)
    );
}
/**
 * Возвращает и очищает очередь всплывающих сообщений.
 *
 * @param string $type тип сообщения.
 * @return array возвращает массив сообщений.
 */
function flushFlashMessages($type = null)
{
    $messages = [];
    if (isset($_SESSION['messages'])) {
        if ($type && isset($_SESSION['messages'][$type])) {
            $messages = $_SESSION['messages'][$type];
            unset($_SESSION['messages'][$type]);
        } else {
            $messages = $_SESSION['messages'];
            unset($_SESSION['messages']);
        }
    }
    return $messages;
}
function p(array $arr, $key, $default = '')
{
    return isset($arr[$key]) ? $arr[$key] : $default;
}