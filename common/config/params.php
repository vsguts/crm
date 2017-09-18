<?php

return [
    'applicationName' => 'CRM',
    'companyName' => 'Vsguts',
    'baseUrl' => 'https://github.com/vsguts/crm/',
    'adminEmail' => 'vsguts@gmail.com',
    'supportEmail' => 'vsguts@gmail.com',

    'user.passwordResetTokenExpire' => 3600,

    'mime_types_to_display' => ['pdf', 'image'],

    'cryptKey' => 'bjkP7LRLfg44Jzkj',
    'dbCryptKey' => 'rup7a5VXJsyH6wux',

    // TODO:Remove
    'dirs' => [
        'file_stored'             => '@root/storage/',
        'image_stored'            => '@webroot/images/stored/',
        'image_stored_thumbnails' => '@webroot/images/stored_thumbnails/',
        'image_uploads'           => '@webroot/images/uploads/',
    ],

];
