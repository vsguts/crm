<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use app\models\Language;


NavBar::begin([
    'brandLabel' => Yii::$app->params['brandName'],
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar-inverse navbar-fixed-top',
    ],
]);

$user = Yii::$app->user;
$controller_id = Yii::$app->controller->id;
$action_id = Yii::$app->controller->action->id;
$action_params = Yii::$app->controller->actionParams;

$is_profile = $controller_id == 'user' && $action_id == 'update' && $user->identity->id == $action_params['id'];

/**
 * Left nav
 */

echo Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-left'],
    'encodeLabels' => false,
    'items' => [
        [
            'label' => Html::tag('b', __('Partners')),
            'url' => ['/partner/index'],
            'visible' => $user->can('partner_manage'),
            'active' => $controller_id == 'partner',
        ],
        [
            'label' => __('Visits'),
            'url' => ['/visit/index'],
            'visible' => $user->can('visit_manage'),
            'active' => $controller_id == 'visit',
        ],
        [
            'label' => __('Donates'),
            'url' => ['/donate/index'],
            'visible' => $user->can('donate_manage'),
            'active' => $controller_id == 'donate',
        ],
        [
            'label' => __('Tasks'),
            'url' => ['/task/index'],
            'visible' => $user->can('task_manage'),
            'active' => $controller_id == 'task',
        ],
    ],
]);

/**
 * Right nav
 */

// Tools
$menu_items[] = [
    // 'label' => '<i class="glyphicon glyphicon-envelope"></i> ',
    'label' => __('Newsletters'),
    'visible' => $user->can('newsletter_manage'),
    'active' => in_array($controller_id, ['newsletter', 'mailing-list', 'print-template']),
    'items' => [
        [
            'label' => __('Mailing lists'),
            'url' => ['/mailing-list/index'],
            'visible' => $user->can('newsletter_manage'),
            'active' => $controller_id == 'mailing-list',
        ],
        [
            'label' => __('Newsletters'),
            'url' => ['/newsletter/index'],
            'visible' => $user->can('newsletter_manage'),
            'active' => $controller_id == 'newsletter',
        ],
        [
            'label' => __('Printing templates'),
            'url' => ['/print-template/index'],
            'visible' => $user->can('newsletter_manage'),
            'active' => $controller_id == 'print-template',
        ],
    ],
];

// Administration
$items = [];
$can_upload = $user->can('upload_images') || $user->can('upload_own_files') || $user->can('upload_common_files');
if ($can_upload) {
    $items[] = [
        'label' => __('Files'),
        'visible' => $can_upload,
        'active' => $controller_id == 'upload',
        'url' => ['/upload/index'],
    ];
}
if ($user->can('user_manage')) {
    if ($items) {
        $items[] = '<li class="divider"></li>';
    }
    $items[] = [
        'label' => __('Users'),
        'url' => ['/user/index'],
        'visible' => $user->can('user_manage'),
        'active' => $controller_id == 'user' && !$is_profile,
    ];
}
if ($user->can('country_manage')) {
    if ($items) {
        $items[] = '<li class="divider"></li>';
    }
    $items[] = [
        'label' => __('Countries'),
        'url' => ['/country/index'],
        'visible' => $user->can('country_manage'),
        'active' => $controller_id == 'country',
    ];
}
if ($user->can('state_manage')) {
    $items[] = [
        'label' => __('States'),
        'url' => ['/state/index'],
        'visible' => $user->can('state_manage'),
        'active' => $controller_id == 'state',
    ];
}
if ($user->can('partner_manage')) {
    if ($items) {
        $items[] = '<li class="divider"></li>';
    }
    $items[] = [
        'label' => __('Export'),
        'visible' => $user->can('partner_manage'),
        'active' => $controller_id == 'export',
        'url' => ['/export/partners'],
    ];
}

$menu_items[] = [
    // 'label' => '<i class="glyphicon glyphicon-cog"></i> ',
    'label' => __('Administration'),
    'visible' => !!$items,
    'active' => in_array($controller_id, ['upload', 'export', 'user', 'country', 'state']) && !$is_profile,
    'items' => $items
];

// Languages
$languages = Language::find()->orderBy(['name' => SORT_ASC])->all();
$select_language = false;
$lang_items = [];
foreach ($languages as $language) {
    if ($language->code == Yii::$app->language) {
        $select_language = $language;
        // break;
    }
    $lang_items[] = [
        'label' => $language->name,
        'url' => ['language/select', 'id' => $language->id, 'current_url' => Url::to()],
        'active' => $language == $select_language,
    ];
}
$menu_items[] = ['label' => $select_language->short_name, 'items' => $lang_items];

// Account
$help_menu = [
    'items' => [
        'contact' => [
            'label' => __('Contact'),
            'url' => ['/site/contact']
        ],
        'about' => [
            'label' => __('About'),
            'url' => ['/site/about']
        ],
    ],
    'active' => $controller_id == 'site' && in_array($action_id, ['contact', 'about']),
];

if (Yii::$app->user->isGuest) {

    $menu_items[] = ['label' => __('Signup'), 'url' => ['/site/signup']];
    $menu_items[] = ['label' => __('Login'), 'url' => ['/site/login']];

    $menu_items[] = [
        'label' => __('Help'),
        'active' => $help_menu['active'],
        'items' => $help_menu['items']
    ];

} else {

    $name = trim($user->identity->fullname);
    if (empty($name)) {
        $name = $user->identity->username;
    }
    $menu_items[] = [
        'label' => '<i class="glyphicon glyphicon-user"></i>',
        'active' => $is_profile || $help_menu['active'],
        'items' => [
            Html::tag('li', Html::a(__('Signed in as <br><b>{name}</b>', ['name' => $name])), ['class'=>'disabled']),
            '<li class="divider"></li>',
            [
                'label' => __('Profile'),
                'url' => ['/user/update', 'id' => $user->identity->id],
                'active' => $is_profile,
            ],
            [
                'label' => __('Logout'),
                'url' => ['/site/logout'],
                'linkOptions' => ['data-method' => 'post']
            ],
            '<li class="divider"></li>',
            $help_menu['items']['contact'],
            $help_menu['items']['about'],
        ]
    ];

}

echo Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-right'],
    'encodeLabels' => false,
    'items' => $menu_items,
]);

/**
 * Search nav
 */
/* Disabled
if ($user->can('partner_manage')) {
    echo '<form class="navbar-form navbar-left" role="search" method="get" action="' . Url::to(['partner/index']) . '">';
    echo '    <div class="form-group">';
    echo '        <input type="text" name="q" class="form-control" placeholder="' . __('Search') . '" value="' . Yii::$app->request->get('q') . '">';
    echo '    </div>';
    echo '</form>';
}
*/

NavBar::end();
