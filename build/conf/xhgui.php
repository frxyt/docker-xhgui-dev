<?php

/**
 * Default generic configuration for Xhgui
 */

return array_merge(array(
    'debug' => false,
    'mode' => 'development',

    'pdo' => array(
        'dsn' => 'sqlite:/tmp/xhgui.sqlite3',
        'user' => null,
        'pass' => null,
        'table' => 'results'
    ),

    'db.options' => array(),
    'templates.path' => dirname(__DIR__) . '/src/templates',
    'date.format' => 'M jS H:i:s',
    'detail.count' => 6,
    'page.limit' => 25,

    // call fastcgi_finish_request() in shutdown handler
    'fastcgi_finish_request' => true,

    // Profile x in 100 requests. (E.g. set XHGUI_PROFLING_RATIO=50 to profile 50% of requests)
    'profiler.enable' => function() {
        $ratio = getenv('XHGUI_PROFILING_RATIO') ?: 100;
        return (getenv('XHGUI_PROFILING') !== false) && (mt_rand(1, 100) <= $ratio);
    },

    'profiler.simple_url' => function($url) {
        return preg_replace('/\=\d+/', '', $url);
    },
    
    'profiler.options' => array(),
),
(getenv('XHGUI_SAVE_HANDLER') === 'file' ? array(
    // Configuration for 'file' save handler
    'save.handler' => 'file',
    'save.handler.filename' => (getenv('XHGUI_SAVE_HANDLER_FILENAME') ?: (getenv('XHGUI_SAVE_HANDLER_FILEPATH') ?: dirname(__DIR__) . '/cache/'))
        . 'xhgui.data.' . microtime(true) . '_' . substr(md5($_SERVER['REQUEST_URI']), 0, 6),
) : (getenv('XHGUI_SAVE_HANDLER') === 'upload' ? array(
    // Configuration for 'upload' save handler
    'save.handler' => 'upload',
    'save.handler.upload.uri' => getenv('XHGUI_SAVE_HANDLER_UPLOAD_URI') ?: 'http://' . (getenv('XHGUI_SAVE_HANDLER_UPLOAD_HOST') ?: 'xhgui') . '/run/import',
    'save.handler.upload.timeout' => getenv('XHGUI_SAVE_HANDLER_UPLOAD_TIMEOUT') ?: 3,
) : array(
    // Configuration for 'mongodb' save handler (it's the default & fallback one)
    'save.handler' => 'mongodb',
    'db.host' => sprintf('mongodb://%s', str_replace('mongodb://', '', (getenv('XHGUI_MONGO_URI') ?: 'xhgui:27017'))),
    'db.db' => (getenv('XHGUI_MONGO_DB') ?: 'xhprof'),
))));