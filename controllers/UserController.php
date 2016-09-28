<?php

namespace app\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use app\models\User;
use app\models\search\UserSearch;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends AbstractController
{
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'verbs' => [
                'class' => 'yii\filters\VerbFilter',
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
            'access' => [
                'class' => 'yii\filters\AccessControl',
                'only' => ['index', 'create', 'delete', 'act_on_behalf'],
                'rules' => [
                    [
                        'allow' => true,
                        'verbs' => ['GET'],
                        'actions' => ['index'],
                        'roles' => ['user_view'],
                    ],
                    [
                        'allow' => true,
                        'verbs' => ['POST'],
                        'actions' => ['act-on-behalf'],
                        'roles' => ['user_act_on_behalf'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create', 'delete'],
                        'roles' => ['user_manage'],
                    ],
                ],
            ],
        ]);
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'update' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', __('Your changes have been saved successfully.'));
            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'roles' => Yii::$app->authManager->getRolesList('guest'),
            ]);
        }
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'update' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel(User::className(), $id);

        $user = Yii::$app->user;

        $post = Yii::$app->request->post();

        if ($user->can('user_manage_own', ['user' => $model])) {
            $allowed = true;
        } elseif ($post) {
            $allowed = $user->can('user_manage');
        } else {
            $allowed = $user->can('user_view');
        }

        if (!$allowed) {
            throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
        }

        if ($post && $model->load($post) && $model->save()) {
            Yii::$app->session->setFlash('success', __('Your changes have been saved successfully.'));
            return $this->redirect(['update', 'id' => $model->id]);
        }

        $auth = Yii::$app->authManager;

        $data = [
            'model' => $model,
        ];

        if (Yii::$app->user->identity->id != $model->id) { // Restrict user to manage own roles
            $data['roles'] = $auth->getRolesList('guest');
        }

        return $this->render('update', $data);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete(array $id)
    {
        return $this->delete(User::className(), $id);
    }

    public function actionActOnBehalf($id)
    {
        $model = $this->findModel(User::className(), $id);
        Yii::$app->user->switchIdentity($model);
        return $this->goHome();
    }

}
