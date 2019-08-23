<?php
/**
 * File save all site's configure on server
 *
 * @package     Config
 */


/**
 * Base Site Config
 */
$config['host']       = 'photo.katran.local';
$config['domain']     = 'photo.katran.local';
$config['schema']     = 'http://';
$config['lang']       = 'ru';
$config['namespace']  = 'Site';
$config['path']       = substr(__FILE__, 0, -22);
$config['path_web']   = $config['path'].'/web/';
$config['path_src']   = $config['path'].'/src/';
$config['path_files'] = $config['path_web'].'/files/';


/**
 * Charset Config
 */
$config['page_charset'] = 'utf-8'; // set in html code, example - layout_admin.php


/**
 * Error , Debug and Log site config
 */
$config['debug']             = 0;
$config['log_path']          = $config['path'].'/app/logs';
$config['log']               = $config['log_path'].'/'.date('Y_m_d').'.log';
$config['error_log']         = $config['log_path'].'/errors/'.date('Y_m_d').'.log';
$config['mail_log']          = $config['log_path'].'/mails/'.date('Y_m_d').'.log';
$config['send_bug_to_email'] = '@gmail.com';


/**
 * Error reporting level
 */
error_reporting(E_ALL);
set_error_handler('\\Katran\\Helper::_errorHandler');
ini_set('display_errors', true);
ini_set('log_errors', true);
ini_set('error_log', $config['error_log']);


/**
 * Base Datebase Config
 */
$config['db']['host']    = 'localhost';
$config['db']['user']    = 'root';
$config['db']['pass']    = '';
$config['db']['name']    = 'photo.katran';
$config['db']['port']    = '3306';
$config['db']['charset'] = 'UTF8';


/**
 * Mail setting
 */
$config['mail']['return_path']      = '@gmail.com';
$config['mail']['return_path_name'] = 'No repty';
$config['mail']['smtp'] = array(
    'host'      => 'smtp.gmail.com',
    'port'      => 587,
    'helo'      => $config['domain'],
    'auth'      => true,
    'secure'    => 'tls',
    'user'      => '@gmail.com',
    'pass'      => '',
    'timeout'   => 5,
);


/**
 * Other Config
 */
$config['date_correct'] = 0;


// need for get array
return $config;
