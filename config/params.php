<?php

return [

    'user.passwordResetTokenExpire' => 3600,

    'dirs' => [
        'image_stored' => '@webroot/images/stored/',
        'image_stored_thumbnails' => '@webroot/images/stored_thumbnails/',
        'image_uploads' => '@webroot/images/uploads/',
        'file_uploads' => '@webroot/files/',
    ],

    // Will be merged by Setting::settings()
    
];
