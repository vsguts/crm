<?php

namespace app\controllers;

use Yii;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use app\models\form\UserRoleForm;

/**
 * UserRoleController implements the CRUD actions for UserRoleForm.
 */
class UserRoleController extends AController
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => 'yii\filters\AccessControl',
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['newsletter_manage'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => 'yii\filters\VerbFilter',
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
            'ajax' => [
                'class' => 'app\behaviors\AjaxFilter',
            ],
        ];
    }

    /**
     * Lists all UserRoleForm models.
     * @return mixed
     */
    public function actionIndex()
    {
        $roles = UserRoleForm::getAllRoles();

        $roles = ArrayHelper::toArray($roles);
        foreach ($roles as &$role) {
            $role['id'] = $role['name']; // Grid need id
        }

        return $this->render('index', [
            'dataProvider' => new ArrayDataProvider([
                'allModels' => $roles,
                'sort' => [
                    'attributes' => [
                        'description',
                        'name',
                    ],
                    'defaultOrder' => [
                        'description' => SORT_ASC,
                    ],
                ],
                'pagination' => [
                    'pageSize' => 10,
                    'pageSizeLimit' => [10, 100],
                ],
            ]),
        ]);
    }

    /**
     * Updates an existing UserRoleForm model.
     * If update is successful, the browser will be redirected to the 'update' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id = null)
    {
        if ($id) {
            $model = $this->findModel($id);
        } else {
            $model = new UserRoleForm;
        }

        if (Yii::$app->request->post()) {
            $model->permissions = [];
            $model->roles = [];
            $model->load(Yii::$app->request->post());
            if ($model->save()) {
                Yii::$app->session->setFlash('success', __('Your changes have been saved successfully.'));
            }
            return $this->redirect(['index', 'name' => $model->name]);
        } else {
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionDelete($id = null, array $ids = null)
    {
        if ($id) {
            $ids[] = $id;
        }

        $deleted = [];
        foreach ($ids as $id) {
            if ($model = $this->findModel($id)) {
                if (!empty($model->data['system'])) {
                    Yii::$app->session->setFlash('error', __('Cannot delete the item.'));
                } else {
                    $deleted[] = $model->name;
                    $model->delete();
                }
            }
        }

        if ($deleted) {
            if (count($deleted) > 1) {
                Yii::$app->session->setFlash('success', __('Items have been deleted successfully.'));
            } else {
                Yii::$app->session->setFlash('success', __('Item has been deleted successfully.'));
            }
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the UserRoleForm model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UserRoleForm the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UserRoleForm::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
