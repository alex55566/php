<?php

require_once 'autoload.php';

use Entities as FS;

$fileStorage = new FS\FileStorage();
var_dump($fileStorage->list());