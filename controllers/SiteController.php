<?php

namespace app\controllers;

use Yii;
use yii\helpers\Url;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\BadRequestHttpException;
use app\models\Partner;
use app\models\Visit;
use app\models\Donate;
use app\models\Task;
use app\models\User;
use app\models\PrintTemplate;
use app\models\form\ContactForm;
use app\models\form\UserLoginForm;
use app\models\form\UserSignupForm;
use app\models\form\UserPasswordResetRequestForm;
use app\models\form\UserResetPasswordForm;

class SiteController extends AController
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
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
        
        if ($user->can('partner_manage')) {
            $dashboard[] = [
                'name' => __('Partners'),
                'link' => Url::to(['partner/index']),
                'count' => Partner::find()->count(),
            ];
        }
        
        if ($user->can('visit_manage')) {
            $dashboard[] = [
                'name' => __('Visits'),
                'link' => Url::to(['visit/index']),
                'count' => Visit::find()->count(),
            ];
        }
        
        if ($user->can('donate_manage')) {
            $dashboard[] = [
                'name' => __('Donates'),
                'link' => Url::to(['donate/index']),
                'count' => Donate::find()->count(),
            ];
        }
        
        if ($user->can('task_manage')) {
            $dashboard[] = [
                'name' => __('Tasks'),
                'link' => Url::to(['task/index']),
                'count' => Task::find()->count(),
            ];
        }
        
        if ($user->can('print_template_manage')) {
            $dashboard[] = [
                'name' => __('Printing templates'),
                'link' => Url::to(['printtemplate/index']),
                'count' => PrintTemplate::find()->count(),
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
