<?php

namespace app\controllers;

use app\models\form\UserRoleForm;
use app\models\search\UserSearch;
use app\models\User;
use Yii;
use yii\web\ForbiddenHttpException;

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
                    'act-on-behalf' => ['post'],
                ],
            ],
            'access' => [
                'class' => 'yii\filters\AccessControl',
                'only' => ['index', 'delete', 'act_on_behalf'],
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
                        'actions' => ['delete'],
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
            'permissions' => (new UserRoleForm)->getAllPermissions(),
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'update' page.
     * @param integer $id
     * @return mixed
     * @throws ForbiddenHttpException
     */
    public function actionUpdate($id = null)
    {
        $post = Yii::$app->request->post();

        $user = Yii::$app->user;

        if ($id) {
            $model = $this->findModel($id, User::className());

            if ($user->can('user_manage_own', ['user' => $model])) {
                $allowed = true;
            } elseif ($post) {
                $allowed = $user->can('user_manage');
            } else {
                $allowed = $user->can('user_view');
            }

        } else {
            $model = new User();

            $allowed = $user->can('user_manage');
        }

        if (!$allowed) {
            throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
        }

        if ($post) {
            if ($model->load($post) && $model->save()) {
                $this->notice(__('Your changes have been saved successfully.'));
            } else {
                $this->notice($model->errors, 'error');
            }
            return $this->redirect(['index']);
        }

        $auth = Yii::$app->authManager;

        $data = [
            'model' => $model,
        ];

        if ($user->id != $model->id) { // Restrict user to manage own roles
            $data['roles'] = $auth->getRolesList(true);
        }

        return $this->render('update', $data);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param array|int $id
     * @return mixed
     */
    public function actionDelete(array $id)
    {
        return $this->delete(User::className(), $id);
    }

    public function actionActOnBehalf($id)
    {
        $model = $this->findModel($id, User::className());
        Yii::$app->user->switchIdentity($model);
        return $this->goHome();
    }

}
