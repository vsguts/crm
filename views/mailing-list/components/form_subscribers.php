<?php

use app\models\MailingListPartner;
use app\models\Partner;

/** @var \app\models\MailingList $model */

$items = Partner::find()->permission()->scroll(['field' => 'extendedName', 'empty' => true]);
$currentPartnerIds = MailingListPartner::find()
    ->where(['list_id' => $model->id])
    ->ids('partner_id');
$selectedItems = array_intersect_key($items, array_flip($currentPartnerIds));

$getLinkOptions = function ($id) {
    return [
        'href' => Url::to(['partner/update', 'id' => $id]),
    ];
};

echo $form->field($model, 'partners_ids[]')->widget('app\widgets\form\Select2', [
    'multiline'    => true,
    'items'        => $items,
    'currentItems' => $selectedItems,
    'options'      => ['placeholder' => __('Select client')],
    'relatedUrl'   => $getLinkOptions,
]);
