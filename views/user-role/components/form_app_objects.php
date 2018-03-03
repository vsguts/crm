<?php

use app\models\Tag;
use yii\bootstrap\Tabs;

// Prepare public tags
$accounts = ['all' => [
    'label' => '- ' . __('All') . ' -',
]];
/** @var Tag $tag */
foreach (Tag::find()->publicTags()->sorted()->all() as $tag) {
    $accounts[$tag->id] = [
        'label' => $tag->name,
        // 'status' => $tag->status,
        'status' => 'active',
    ];
}


echo Tabs::widget([
    'options' => [
        'id' => $form_id . '_app_objects_tabs',
    ],
    'navType' => 'nav-pills',
    'items' => [
        [
            'label' => __('Public tags'),
            'content' => $form
                ->field($model, 'data[public_tags]')
                ->label(__('Public tags'))
                ->checkboxList($accounts, [
                    'item' => function($index, $label, $name, $checked, $value) use($model) {
                        $status_class = '';
                        if (!empty($label['status'])) {
                            $status_class = 'status-' . $label['status'];
                        }
                        return Html::tag(
                            'div',
                            Html::checkbox($name, $checked, ['label' => $label['label'], 'value' => $value]),
                            ['class' => ['checkbox', $status_class]]
                        );
                    },
                ]),
        ],
    ],
]);

