<?php

function mailer_settings()
{
    return [
        'host' => 'smtp.gmail.com',
        'auth' => true,
        'port' => 465,
        'username' => 'asmolyanov555@gmail.com',
        'password' => '............',
        'charset' => 'UTF-8',
        'from_email' => 'asmolyanov555@gmail.com',
        'from_name' => 'Alex',
        'is_html' => true,
    ];
}