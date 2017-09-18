<?php

use common\models\Tag;

echo $form
    ->field($model, 'data[public_tags]')
    ->label(__('Public tags'))
    ->checkboxList(
        Tag::find()->publicTags()->scroll(['all' => true, 'all_key' => 'all'])
    );
