<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP и HTML</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php

use \App\Entities\TelegraphText;
use \App\Entities\FileStorage;

require_once('autoload.php');
?>

<?php

$resMailer = true;
$resCheckLen = true;

if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];
    if ($name && $message) {
        $telegraph = new TelegraphText($name, 'test.txt');
        $telegraph->editText('Форма регистрации', $message);
        $telegraph->text = $message;


        try {
            var_dump($telegraph->checklengthText());
        } catch (TelegraphException $exception) {
            $exception->getMessage();
        } finally {
            var_dump('finally');
        }


        $telegraph->title = 'Форма регистрации';
//        $fileStorage = new FileStorage();
//        $fileStorage->create($telegraph);
    }
//    if ($email && $name && $message) {
//        $body = 'My name is ' . $name . ' my message is ' . $message;
//        $resMailer = mailer(mailer_settings(), $email, 'Форма регистрации', $body,);
//    }
}

?>

<form class="form" method="post">
    <?php
    if (!$resMailer) {
        ?>
        <div>Ошибка отправки</div>
        <?php
    }
    if (!$resCheckLen) {
        ?>
        <div>Ошибка сохранения файла. Длина не соответствует допустимой</div>
        <?php
    }
    ?>
    <h1>Форма регистрации</h1>
    <div>
        <label for="name">Фамилия Имя Отчество:</label>
        <input id="name" type="text" name="name" class="reg-form"/>
    </div>
    <div>
        <label for="email">E-mail:</label>
        <input id="email" type="email" name="email" class="reg-form"/>
    </div>
    <div>
        <label>Комментарии</label>
        <textarea name="message" class="reg-form textarea"></textarea>
    </div>
    <div>
        <input type="reset" value="Сбросить">
        <input type="submit" value="Отправить">
    </div>
</form>


</body>
</html>

