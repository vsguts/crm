<?php

return [

    'user.passwordResetTokenExpire' => 3600,

    'dirs' => [
        'file_stored'             => '@app/files/stored/',

        'image_stored'            => '@webroot/images/stored/',
        'image_stored_thumbnails' => '@webroot/images/stored_thumbnails/',
        'image_uploads'           => '@webroot/images/uploads/',
    ],

    'mime_types_to_display' => ['pdf', 'image'],

    // Will be merged by Setting::settings()
    
];
