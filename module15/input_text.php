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

<form class="form" method="post">
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

<?php
if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    if ($name && $message) {
        $telegraph = new TelegraphText($_POST['name'], 'test.txt');
        $telegraph->editText('Форма регистрации', $_POST['message']);
        $telegraph->text = $_POST['message'];
        $telegraph->title = 'Форма регистрации';
        $fileStorage = new FileStorage();
        $fileStorage->create($telegraph);
        var_dump($fileStorage->list());
    }
}
?>

</body>
</html>

