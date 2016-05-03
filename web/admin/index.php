<?php

/**
 * It's main file of all site
 */

/**
 * Include application
 */
require_once dirname(dirname(__DIR__)).'/app/app.php';

use Katran\Helper;
use Katran\Model\Accounts as BaseAccounts;

/**
 * Set area
 */
$app->setArea(BaseAccounts::AREA_ADMIN);


/**
 * Run process and show result
 */
$app->process();
$app->display();

