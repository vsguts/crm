<?php

namespace app\controllers;

use app\controllers\behaviors\AjaxFilter;
use app\controllers\traits\ExportTrait;
use app\models\Communication;
use app\models\export\CommunicationExport;
use app\models\search\CommunicationSearch;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

/**
 * CommunicationController implements the CRUD actions for Communication model.
 */
class CommunicationController extends AbstractController
{
    use ExportTrait;

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
                        'roles' => ['communication_view', 'communication_view_own'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['export', 'export-download'],
                        'roles' => ['communication_view', 'communication_view_own'],
                    ],
                    [
                        'allow' => true,
                        'verbs' => ['POST'],
                        'roles' => ['communication_manage'],
                    ],
                ],
            ],
            'ajax' => [
                'class' => AjaxFilter::class,
            ],
        ]);
    }

    /**
     * Lists all Communication models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CommunicationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Updates an existing Communication model.
     * If update is successful, the browser will be redirected to the 'update' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id = null, $partner_id = null)
    {
        if ($id) {
            $model = $this->findModel($id, Communication::class);
        } else {
            $model = new Communication();
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', __('Your changes have been saved successfully.'));
            return $this->redirect(['index']);
        } else {

            if (!$id) {
                $model->timestamp = Yii::$app->formatter->asDate(time());
                $model->user_id = Yii::$app->user->id;
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
     * Deletes an existing Communication model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id = null, array $ids = null)
    {
        $ok_message = false;

        if (!$id && $ids) { // multiple
            if (Communication::deleteAll(['id' => $ids])) {
                $ok_message = __('Items have been deleted successfully.');
            }
        } elseif ($this->findModel($id, Communication::class)->delete()) { // single
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

    public function actionExport()
    {
        return $this->performExport(
            new CommunicationExport(),
            (new CommunicationSearch())->search(Yii::$app->request->queryParams)
        );
    }
}
