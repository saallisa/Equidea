<?php

// Server configurations file
$container->setConfig('templating', [
    'view_path' => __DIR__ .'/../view/',
    'view_extension' => '.php',
    'view_language' => 'DE',
    'view_charset' => 'UTF-8',
    'lang_path' => __DIR__ .'/../lang/'
]);
