<?php

namespace app\controllers;

use app\models\form\UserRoleForm;
use Yii;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;
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
        $roles = UserRoleForm::getAllRoles(['get_links' => true]);

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
                    'pageSizeLimit' => [50, 500],
                    'defaultPageSize' => 100,
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

        if ($post = Yii::$app->request->post()) {
            $model->permissions = [];
            $model->roles = [];
            $model->load($post);
            if ($model->save()) {
                $this->notice(__('Your changes have been saved successfully.'));
            }
            return $this->redirect(['index', 'name' => $model->name]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete(array $id)
    {
        $deleted = [];
        foreach ($id as $_id) {
            if ($model = $this->findModel($_id)) {
                if (!empty($model->data['system'])) {
                    $this->notice(__('Cannot delete the item.'), 'error');
                } else {
                    $deleted[] = $model->name;
                    $model->delete();
                }
            }
        }

        if ($deleted) {
            if (count($deleted) > 1) {
                $this->notice(__('Items have been deleted successfully.'));
            } else {
                $this->notice(__('Item has been deleted successfully.'));
            }
            if ($referrer = Yii::$app->request->referrer) {
                return $this->redirect($referrer);
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
    protected function findModel($id, $object = null)
    {
        if ($model = UserRoleForm::findOne($id)) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
