<?php

$folders = ['lib/', 'app/', 'api/'];
foreach ($folders as $folder) {
    foreach (new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($folder),
        RecursiveIteratorIterator::SELF_FIRST
    ) as $file) {
        if (!$file->isFile()) {
            continue;
        }

        require_once $file->getPathName();
    }
}

$loader = require 'vendor/autoload.php';
$loader->register();
