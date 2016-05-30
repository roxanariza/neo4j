<?php
return [
    'components' => [
        'db' => [
//            'class' => 'yii\db\Connection',
//            'dsn' => 'mysql:host=localhost;dbname=yii2advanced',
//            'username' => 'root',
//            'password' => '',
//            'charset' => 'utf8',
            'class' => '\neo4j\db\Connection',
    'host' => 'localhost', // Default
    'port' => 7474, // Default
    'username' => 'neo4j', // Default
    'password' => '123456', // Default
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
    ],
];
