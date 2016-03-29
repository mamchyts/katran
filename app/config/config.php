<?php
/**
 * File save all site's configure for work
 * 
 * @package     Config
 */

/**
 * Watermark default text
 * @var string
 */
$config['watermark_text'] = '';


/**
 * Default file/folder mode
 * @var array
 */
$config['filemode'] = [
    'file' => 0666,
    'folder' => 0777,
];


/**
 * Available values for $count used in Pager
 * @var array
 */
$config['available_counts'] = [
    '12' => 12,
    '20' => 20,
    '28' => 28,
];


/**
 * Available values for $count used in Pager
 * @var array
 */
$config['available_counts_admin'] = [
    '50'    => '50',
    '100'   => '100',
    '200'   => '200',
    '99999' => 'Все',
];


/**
 * Available values for admin roles
 * @var array
 */
$config['areas'] = [
    'admin' => 'админ',
    'member' =>  'пользователь',
    'visitor' => 'гость',
];


/**
 * Available values for admin roles
 * @var array
 */
$config['roles'] = [
    'admin' => 'администратор',
];


/**
 * Available values for status
 * @var array
 */
$config['statuses'] = [
    'active' => 'активен',
    'hidden' => 'не активен',
];


/**
 * Available values for image thumbnails
 * @var array
 */
$config['image_thumbnails'] = [
    'slideshow' => [
        [1000, 400],
    ],
    'sizes' => [
        [240,  135],
        [480,  270],
        [960,  540],
        [480,  'widen'],
        [960,  'heighten'],
        [1080, 'heighten'],
    ],
];


// need for get array
return $config;