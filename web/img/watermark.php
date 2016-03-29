<?php

    // get path from $_GET, for more details @see ./.htaccess
    $path = dirname(__FILE__).'/'.$_GET['path'];

    // Check file
    if(!file_exists($path) || empty($_SERVER['HTTP_REFERER'])){
        header("HTTP/1.0 404 Not Found");
        exit;
    }

    // get image information
    $info = getimagesize($path);

    // clean buffer
    if (ob_get_level())
        ob_end_clean();

    // Send the image
    header('Content-type: '.$info['mime']);
    readfile($path);
    exit();
?>