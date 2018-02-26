<?php

define('SECONDS_IN_DAY', 24 * 60 * 60);
define('SECONDS_IN_YEAR', SECONDS_IN_DAY * 365);

define('QUERY_BATCH_LIMIT', 500);

return [

    'user.passwordResetTokenExpire' => 3600,

    'dirs' => [
        'file_stored'             => '@app/files/stored/',

        'image_stored'            => '@webroot/images/stored/',
        'image_stored_thumbnails' => '@webroot/images/stored_thumbnails/',
        'image_uploads'           => '@webroot/images/uploads/',
    ],

    'mime_types_to_display' => ['pdf', 'image'],

    'cryptKey' => 'kxEu8HGH5dGDLny',
    'dbCryptKey' => '321qwedsazxc',

    // Will be merged by Setting::settings()
    
];
