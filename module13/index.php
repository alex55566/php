<?php
require_once 'vendor/autoload.php';

$fileStorage = new \App\Entities\FileStorage();
var_dump($fileStorage->list());
