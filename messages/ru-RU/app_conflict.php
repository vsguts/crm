<?php

$messages = [
    'Name' => 'Название',
];

if (file_exists(__DIR__ . '/app_conflict.local.php')) {
    $messages = array_merge(
        $messages,
        include(__DIR__ . '/app_conflict.local.php')
    );
}

return $messages;
