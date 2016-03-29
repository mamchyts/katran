<?php

/**
 * It's main file of all site
 */

/**
 * Include application
 */
require_once '../app/app.php';

/**
 * Set area
 */
$app->setArea('visitor');

/**
 * Run process and show result
 */
$app->process();
$app->display();

