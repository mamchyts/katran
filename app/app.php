<?php

/**
 * Main file of all project
 */
require_once __DIR__ . '/../vendor/autoload.php';


use Katran\Application;
use Katran\Helper;


// set config parameters
$files = [
    __DIR__.'/config/config.php',
    __DIR__.'/config/server.php',
];
Helper::_setCfg($files);


// set messages texts
$files = [
    __DIR__.'/config/messages.php',
];
Helper::_setMsg($files);


// init application
$app = new Application();
