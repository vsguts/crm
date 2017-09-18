<?php

namespace backend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\BadRequestHttpException;
use common\models\Donate;
use common\models\Newsletter;
use common\models\MailingList;
use common\models\Partner;
use common\models\PrintTemplate;
use common\models\Task;
use common\models\Communication;
use common\models\User;
use common\models\form\ContactForm;
use common\models\form\UserLoginForm;
use common\models\form\UserSignupForm;
use common\models\form\UserPasswordResetRequestForm;
use common\models\form\UserResetPasswordForm;

class SiteController extends AbstractController
{
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['signup', 'login', 'logout', 'contact', 'about', 'faq'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['signup', 'login'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['logout'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['contact'],
                        'roles' => ['contact_form'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['about'],
                        'roles' => ['about_page'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['faq'],
                        'roles' => ['faq_page'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ]);
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        $user = Yii::$app->user;
        $dashboard = [];

        if ($user->can('partner_view') || $user->can('partner_view_own')) {
            $dashboard[] = [
                'name' => Html::tag('b', __('Partners')),
                'link' => Url::to(['partner/index']),
                'count' => Partner::find()->count(),
            ];
        }

        if ($user->can('donate_view') || $user->can('donate_view_own')) {
            $dashboard[] = [
                'name' => __('Donates'),
                'link' => Url::to(['donate/index']),
                'count' => Donate::find()->count(),
            ];
        }

        if ($user->can('communication_view') || $user->can('communication_view_own')) {
            $dashboard[] = [
                'name' => __('Communications'),
                'link' => Url::to(['communication/index']),
                'count' => Communication::find()->count(),
            ];
        }

        if ($user->can('task_view') || $user->can('task_view_own')) {
            $dashboard[] = [
                'name' => __('Tasks'),
                'link' => Url::to(['task/index']),
                'count' => Task::find()->count(),
            ];
        }
        
        if ($user->can('newsletter_view')) {
            $dashboard[] = [
                'name' => __('E-mail newsletters'),
                'link' => Url::to(['newsletter/index']),
                'count' => Newsletter::find()->count(),
            ];
            $dashboard[] = [
                'name' => __('Printing templates'),
                'link' => Url::to(['print-template/index']),
                'count' => PrintTemplate::find()->count(),
            ];
            $dashboard[] = [
                'name' => __('Mailing lists'),
                'link' => Url::to(['mailing-list/index']),
                'count' => MailingList::find()->count(),
            ];
        }
        
        if ($user->can('user_manage')) {
            $dashboard[] = [
                'name' => __('Users'),
                'link' => Url::to(['user/index']),
                'count' => User::find()->count(),
            ];
        }

        return $this->render('index', [
            'dashboard' => $dashboard
        ]);
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new UserLoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', __('Thank you for contacting us. We will respond to you as soon as possible.'));
            } else {
                Yii::$app->session->setFlash('error', __('There was an error sending email.'));
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionFaq()
    {
        return $this->render('faq');
    }

    public function actionSignup()
    {
        $model = new UserSignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    public function actionRequestPasswordReset()
    {
        $model = new UserPasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->getSession()->setFlash('success', __('Check your email for further instructions.'));

                return $this->goHome();
            } else {
                Yii::$app->getSession()->setFlash('error', __('Sorry, we are unable to reset password for email provided.'));
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    public function actionResetPassword($token)
    {
        try {
            $model = new UserResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->getSession()->setFlash('success', __('New password was saved.'));

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

}
