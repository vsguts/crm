<?php

namespace app\controllers;

use app\models\AuthItem;
use app\models\search\AuthItemSearch;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * UserRoleController implements the CRUD actions for UserRoleForm.
 */
class UserRoleController extends AbstractController
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
                'rules' => [
                    [
                        'allow' => true,
                        'verbs' => ['GET'],
                        'actions' => ['index', 'update'],
                        'roles' => ['user_role_view'],
                    ],
                    [
                        'allow' => true,
                        'verbs' => ['POST'],
                        'roles' => ['user_role_manage'],
                    ],
                ],
            ],
        ]);
    }

    /**
     * Lists all UserRoleForm models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AuthItemSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Updates an existing AuthItem model.
     * If update is successful, the browser will be redirected to the 'update' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id = null)
    {
        if ($id) {
            $model = $this->findModel($id);
        } else {
            $model = new AuthItem;
        }

        if ($post = Yii::$app->request->post()) {
            if ($model->load($post) && $model->save()) {
                $this->notice(__('Your changes have been saved successfully.'));
            } else {
                $this->notice($model->errors, 'danger');
            }
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete()
    {
        $models = AuthItem::find()
            ->where(['name' => $this->getRequest('id')])
            ->roles()
            ->nonSystem()
            ->all();

        if ($models) {
            foreach ($models as $model) {
                $model->delete();
            }

            if (count($models) > 1) {
                $this->notice(__('Items have been deleted successfully.'));
            } else {
                $this->notice(__('Item has been deleted successfully.'));
            }
        }

        if ($referrer = Yii::$app->request->referrer) {
            return $this->redirect($referrer);
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the AuthItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @param null    $object
     * @param null    $permission
     * @return AuthItem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id, $object = null, $permission = null)
    {
        if ($model = AuthItem::find()->roles()->where(['name' => $id])->one()) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
