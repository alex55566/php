<?php

use \App\Entities\TelegraphText;
use \App\Entities\FileStorage;
use \App\Entities\TelegraphException;

require_once('autoload.php');

$resMailer = true;
$resCheckLen = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];
    if ($name && $message) {
        $telegraph = new TelegraphText($name, 'test.txt');
        $telegraph->editText('Form registration', $message);
        $telegraph->text = $message;

        try {
            $telegraph->checklengthText();
        } catch (TelegraphException $exception) {
            header("Location: index.php?error=length");
            exit();
        }

        $telegraph->title = 'Form registration';
        $fileStorage = new FileStorage();
        $fileStorage->create($telegraph);
    }
    if ($email && $name && $message) {
        $body = 'My name is ' . $name . ' my message is ' . $message;
        $resMailer = mailer(mailer_settings(), $email, 'Form registration', $body,);
    }

    if (!$resMailer) {
        header("Location: index.php?error=mail");
        exit();
    } else {
        header("Location: success.php");
        exit();
    }
}
?>