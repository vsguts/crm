<?php

namespace backend\controllers;

use common\models\Partner;
use common\models\search\TaskSearch;
use common\models\Task;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

/**
 * TaskController implements the CRUD actions for Task model.
 */
class TaskController extends AbstractController
{
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'verbs' => ['GET'],
                        'actions' => ['index', 'update'],
                        'roles' => ['task_view', 'task_view_own'],
                    ],
                    [
                        'allow' => true,
                        'verbs' => ['POST'],
                        'roles' => ['task_manage'],
                    ],
                ],
            ],
        ]);
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
     * @param null    $partner_id
     * @return mixed
     */
    public function actionUpdate($id = null, $partner_id = null)
    {
        if ($id) {
            $model = $this->findModel($id, Task::class);
        } else {
            $model = new Task();
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->notice(__('Your changes have been saved successfully.'));
            return $this->redirect(['index']);
        } else {

            if (!$id) {
                $model->timestamp = Yii::$app->formatter->asDate(time());
                $model->user_id = Yii::$app->user->id;
            }

            $data = [
                'model' => $model,
            ];
            if ($partner_id) {
                $data['partner'] = Partner::findOne($partner_id);
            }

            return $this->renderAjax('update', $data);
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
        } elseif ($this->findModel($id, Task::class)->delete()) { // single
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

}
