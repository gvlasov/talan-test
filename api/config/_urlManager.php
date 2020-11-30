<?php
return [
    'class' => 'yii\web\UrlManager',
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'enableStrictParsing' => true,
    'rules' => [
        'GET <module:v1>/chat/list' => '<module>/chat/list',
        'GET <module:v1>/chat/<chatId:\d+>/messages' => '<module>/chat/messages',
        'GET <module:v1>/chat/<chatId:\d+>/users' => '<module>/chat/users',
        'POST <module:v1>/chat' => '<module>/chat/create',
        'POST <module:v1>/chat/<chatId:\d+>/message' => '<module>/chat/send-message',
        'DELETE <module:v1>/chat/<chatId:\d+>' => '<module>/chat/delete',
        'DELETE <module:v1>/message/<messageId:\d+>' => '<module>/chat/delete-message',
        'PUT <module:v1>/chat/<chatId:\d+>/enter' => '<module>/chat/enter',
        'PUT <module:v1>/chat/<chatId:\d+>/quit' => '<module>/chat/quit',
    ],
];
