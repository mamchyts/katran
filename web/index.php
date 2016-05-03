<?php

/**
 * It's main file of all site
 */

/**
 * Include application
 */
require_once dirname(__DIR__).'/app/app.php';

use Katran\Helper;
use Katran\Model\Accounts as BaseAccounts;

/**
 * Set area
 */
$app->setArea(BaseAccounts::AREA_VISITOR);


/**
 * Run process and show result
 */
$app->process();
$app->display();

