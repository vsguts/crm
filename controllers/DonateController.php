<?php

namespace app\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\Donate;
use app\models\search\DonateSearch;

/**
 * DonateController implements the CRUD actions for Donate model.
 */
class DonateController extends AbstractController
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
                        'roles' => ['donate_view', 'donate_view_all'],
                    ],
                    [
                        'allow' => true,
                        'verbs' => ['POST'],
                        'roles' => ['donate_manage'],
                    ],
                ],
            ],
            'ajax' => [
                'class' => 'app\behaviors\AjaxFilter',
            ],
        ];
    }

    /**
     * Lists all Donate models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DonateSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Updates an existing Donate model.
     * If update is successful, the browser will be redirected to the 'update' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id = null, $partner_id = null)
    {
        if ($id) {
            $model = $this->findModel($id);
        } else {
            $model = new Donate();
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', __('Your changes have been saved successfully.'));
            return $this->redirect(['index']);
        } else {

            if (!$id) {
                $model->timestamp = Yii::$app->formatter->asDate(time());
                if ($partner_id) {
                    $model->partner_id = $partner_id;
                }
            }

            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Donate model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id = null, array $ids = null)
    {
        $ok_message = false;
        
        if (!$id && $ids) { // multiple
            if (Donate::deleteAll(['id' => $ids])) {
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
     * Finds the Donate model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Donate the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Donate::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
