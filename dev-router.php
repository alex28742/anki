<?php
/**
 * DEV-ONLY роутер для встроенного сервера PHP (`php -S`).
 * НЕ используется в production - там раздачей и переписыванием путей
 * занимается Apache + .htaccess.
 *
 * Запуск (из корня проекта, корень проекта = document root,
 * как и ожидают app/config/constants.php и .htaccess в проде):
 *
 *   php -S 127.0.0.1:8001 -t . dev-router.php
 *
 * Логика повторяет .htaccess:
 *  - запросы к реально существующим файлам внутри /public/ отдаются как
 *    статика (css/js/img/favicon и т.д.);
 *  - все остальные запросы уходят в public/index.php, который сам
 *    разбирает маршрут (Router::dispatch) - как на проде.
 *
 * Все остальные файлы проекта (app/, composer.json, логи и т.п.)
 * заведомо не раздаются как статика - только через public/.
 */

$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

if (preg_match('#^/public/#', $uri)) {
    $file = __DIR__ . $uri;
    if (is_file($file)) {
        return false; // пусть встроенный сервер отдаст файл сам
    }
}

// app/config/constants.php строит путь как $_SERVER['DOCUMENT_ROOT']."app"
// (без разделителя), т.е. ожидает DOCUMENT_ROOT с завершающим слешем -
// так отдает его Apache в проде. Встроенный сервер PHP отдает его БЕЗ
// слеша, поэтому нормализуем здесь, не трогая сам constants.php.
$_SERVER['DOCUMENT_ROOT'] = rtrim($_SERVER['DOCUMENT_ROOT'], '/') . '/';

require __DIR__ . '/public/index.php';
