<?php

/**
 * @var $c  \Slim\Container
 * @return Logger
 */

use Monolog\Logger;

return function ($c) {
    $logger = new Logger('bot_logger');
    $file_handler = new \Monolog\Handler\StreamHandler(base_path('storage/logs/webcontrol.log'));
    $logger->pushHandler($file_handler);
    return $logger;
};