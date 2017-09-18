<?php

/** @var \common\models\MailingList $model */
/** @var \common\widgets\form\ActiveForm $form */

echo $form->field($model, 'partners_ids[]')->widget('common\widgets\form\Select2', [
    'multiline' => true,
    'url' => ['partner/list'],
    'currentItems' => $model->getPartners()->scroll(),
    'relatedUrl' => function($id) {
        return [
            'href' => Url::to(['partner/update', 'id' => $id]),
            'target' => '_blank',
        ];
    }
]);
