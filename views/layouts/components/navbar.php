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
    'innerContainerOptions' => [
        'class' => 'container-fluid',
    ]
]);

$user = Yii::$app->user;
$controller_id = Yii::$app->controller->id;
$action_id = Yii::$app->controller->action->id;
$action_params = Yii::$app->controller->actionParams;


$proccess_menu_item = function ($menu_item) {
    $items = isset($menu_item['items']) ? $menu_item['items'] : [];
    $sections = isset($menu_item['sections']) ? $menu_item['sections'] : [];

    if ($sections) {
        foreach ($sections as $key => $section) {
            $section = array_filter(
                $section,
                function ($item) {
                    return isset($item['visible']) && $item['visible'];
                }
            );

            if (!$section) {
                unset($sections[$key]);
            }
        }
        $is_first = true;
        foreach ($sections as $section) {
            if (!$is_first) {
                array_unshift($section, '<li class="divider"></li>');
            }
            $is_first = false;
            $items = array_merge($items, $section);
        }
    }

    $menu_item['active'] = false;
    $menu_item['visible'] = false;

    if ($items) {
        foreach ($items as $item) {
            if (isset($item['active']) && $item['active']) {
                $menu_item['active'] = true;
            }
            if (isset($item['visible'])) {
                $menu_item['visible'] = $item['visible'];
            } else {
                $menu_item['visible'] = true;
            }
        }
    }
    $menu_item['items'] = $items;

    return $menu_item;
};


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
            'visible' => $user->can('partner_view') || $user->can('partner_view_own'),
            'active' => $controller_id == 'partner',
        ],
        [
            'label' => __('Donates'),
            'url' => ['/donate/index'],
            'visible' => $user->can('donate_view') || $user->can('donate_view_own'),
            'active' => $controller_id == 'donate',
        ],
        [
            'label' => __('Visits'),
            'url' => ['/visit/index'],
            'visible' => $user->can('visit_view') || $user->can('visit_view_own'),
            'active' => $controller_id == 'visit',
        ],
        [
            'label' => __('Tasks'),
            'url' => ['/task/index'],
            'visible' => $user->can('task_view') || $user->can('task_view_own'),
            'active' => $controller_id == 'task',
        ],
    ],
]);


/**
 * Right nav
 */

// Tools
$menu_items = [

    // Newsletters
    $proccess_menu_item([
        // 'label' => '<i class="glyphicon glyphicon-envelope"></i> ',
        'label' => __('Newsletters'),
        'sections' => [
            [
                [
                    'label'   => __('E-mail newsletters'),
                    'url'     => ['/newsletter/index'],
                    'visible' => $user->can('newsletter_view'),
                    'active'  => $controller_id == 'newsletter',
                ],
            ],
            [
                [
                    'label'   => __('Printing templates'),
                    'url'     => ['/print-template/index'],
                    'visible' => $user->can('newsletter_view'),
                    'active'  => $controller_id == 'print-template',
                ],
            ],
            [
                [
                    'label'   => __('Mailing lists'),
                    'url'     => ['/mailing-list/index'],
                    'visible' => $user->can('newsletter_view'),
                    'active'  => $controller_id == 'mailing-list',
                ],
            ],
        ],
    ]),

    // Administration
    $proccess_menu_item([
        'label' => __('Administration'),
        'sections' => [
            [
                [
                    'label' => __('Users'),
                    'url' => ['/user/index'],
                    'visible' => $user->can('user_view'),
                    'active' => $controller_id == 'user',
                ],
                [
                    'label' => __('User roles'),
                    'url' => ['/user-role/index'],
                    'visible' => $user->can('user_role_view'),
                    'active' => $controller_id == 'user-role',
                ],
            ],
            [
                [
                    'label' => __('Countries'),
                    'url' => ['/country/index'],
                    'visible' => $user->can('country_view'),
                    'active' => $controller_id == 'country',
                ],
                [
                    'label' => __('States'),
                    'url' => ['/state/index'],
                    'visible' => $user->can('state_view'),
                    'active' => $controller_id == 'state',
                ],
            ],
            [
                [
                    'label' => __('Settings'),
                    'visible' => $user->can('setting_manage'),
                    'active' => $controller_id == 'setting',
                    'url' => ['/setting/index'],
                ],
            ],
        ],
    ]),

    // Help
    $proccess_menu_item([
        'label' => __('Help'),
        'items' => [
            // [
            //     'label'   => __('FAQ'),
            //     'url'     => ['/site/faq'],
            //     'visible' => $user->can('faq_page'),
            //     'active'  => $controller_id == 'site' && $action_id == 'faq',
            // ],
            [
                'label' => __('Contact'),
                'url' => ['/site/contact'],
                // 'visible' => $user->can('contact_form'),
                'active'  => $controller_id == 'site' && $action_id == 'contact',
            ],
            [
                'label' => __('About'),
                'url' => ['/site/about'],
                // 'visible' => $user->can('about_page'),
                'active'  => $controller_id == 'site' && $action_id == 'about',
            ],
        ],
    ]),
];

// Languages
$select_language = false;
$lang_items = [];
foreach (Language::find()->orderBy(['name' => SORT_ASC])->all() as $language) {
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
if (!$select_language) {
    $select_language = Language::find()->where(['code' => 'en-US'])->one();
}
$menu_items[] = ['label' => $select_language->short_name, 'items' => $lang_items];

// Account

if (Yii::$app->user->isGuest) {
    $menu_items[] = ['label' => __('Signup'), 'url' => ['/site/signup']];
    $menu_items[] = ['label' => __('Login'), 'url' => ['/site/login']];
} else {
    $name = trim($user->identity->name);
    if (empty($name)) {
        $name = $user->identity->email;
    }
    $menu_items[] = [
        'label' => '<i class="glyphicon glyphicon-user"></i>',
        'items' => [
            Html::tag(
                'li',
                Html::a(__('Signed in as <br><b>{name}</b>', ['name' => $name])),
                ['class'=>'disabled']
            ),
            '<li class="divider"></li>',
            [
                'label' => __('Profile'),
                'url' => ['/user/update', 'id' => $user->identity->id],
                'visible' => true,
                'linkOptions' => [
                    'class' => 'app-modal',
                    'data-target-id' => 'user_' . $user->identity->id,
                ],
            ],
            [
                'label' => __('Logout'),
                'url' => ['/site/logout'],
                'linkOptions' => ['data-method' => 'post'],
                'visible'     => true,
            ],
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
if ($user->can('partner_view')) {
    echo '<form class="navbar-form navbar-left" role="search" method="get" action="' . Url::to(['partner/index']) . '">';
    echo '    <div class="form-group">';
    echo '        <input type="text" name="q" class="form-control" placeholder="' . __('Search') . '" value="' . Yii::$app->request->get('q') . '">';
    echo '    </div>';
    echo '</form>';
}
*/

NavBar::end();
