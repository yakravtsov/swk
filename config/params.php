<?php

return [
    'emailRobot' => ['robot@studentsonline.ru'=>'StudentsOnline.ru: Робот'],
    'emailRobotTransport' => [
        'class'      => 'Swift_SmtpTransport',
        'host'       => 'smtp.yandex.ru',
        'port'       => '465',
        'username'   => 'robot@studentsonline.ru',
        'password'   => 'eR2EFsBi',
        'encryption' => 'ssl',
    ],
    'adminEmail' => 'yakravtsov@gmail.com',
    'pochta' => ['pochta@studentsonline.ru'=>'StudentsOnline.ru'],
    'uploadPath' => __DIR__. '/../uploads/',
];
