<?php

namespace app\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\Task;
use app\models\Partner;
use app\models\search\TaskSearch;

/**
 * TaskController implements the CRUD actions for Task model.
 */
class TaskController extends AbstractController
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'verbs' => ['GET'],
                        'actions' => ['index', 'update'],
                        'roles' => ['task_view', 'task_view_all'],
                    ],
                    [
                        'allow' => true,
                        'verbs' => ['POST'],
                        'roles' => ['task_manage'],
                    ],
                ],
            ],
            'ajax' => [
                'class' => 'app\behaviors\AjaxFilter',
            ],
        ];
    }

    /**
     * Lists all Task models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TaskSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Updates an existing Task model.
     * If update is successful, the browser will be redirected to the 'update' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id = null, $partner_id = null)
    {
        if ($id) {
            $model = $this->findModel($id);
        } else {
            $model = new Task();
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', __('Your changes have been saved successfully.'));
            return $this->redirect(['index']);
        } else {

            if (!$id) {
                $model->timestamp = Yii::$app->formatter->asDate(time());
                $model->user_id = Yii::$app->user->id;
                if ($partner_id) {
                    $model->select_partner = Partner::findOne($partner_id);
                }
            }

            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Task model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id = null, array $ids = null)
    {
        $ok_message = false;
        
        if (!$id && $ids) { // multiple
            if (Task::deleteAll(['id' => $ids])) {
                $ok_message = __('Items have been deleted successfully.');
            }
        } elseif ($this->findModel($id)->delete()) { // single
            $ok_message = __('Item has been deleted successfully.');
        }

        if ($ok_message) {
            Yii::$app->session->setFlash('success', $ok_message);
            // if ($referrer = Yii::$app->request->referrer) {
            //     return $this->redirect($referrer);
            // }
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Task model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Task the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Task::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
