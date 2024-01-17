<?php
require_once 'vendor/autoload.php';

use \App\Entities\FileStorage as FS;
$fileStorage = new FS();

var_dump($fileStorage->list());
