<?php

namespace app\controllers;

use Yii;
use app\models\MailingList;
use app\models\search\MailingListSearch;
use app\models\form\MailingListAppendPartner;
use yii\web\NotFoundHttpException;

/**
 * MailingListController implements the CRUD actions for MailingList model.
 */
class MailingListController extends AController
{
    public function behaviors()
    {
        return [
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
                        'roles' => ['newsletter_view'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['newsletter_manage'],
                    ],
                ],
            ],
            'ajax' => [
                'class' => 'app\behaviors\AjaxFilter',
            ],
        ];
    }

    /**
     * Lists all MailingList models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MailingListSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new MailingList model.
     * If creation is successful, the browser will be redirected to the 'update' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MailingList();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', __('Your changes have been saved successfully.'));
            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing MailingList model.
     * If update is successful, the browser will be redirected to the 'update' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', __('Your changes have been saved successfully.'));
            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing MailingList model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @param array   $ids
     * @return mixed
     */
    public function actionDelete($id = null, array $ids = null)
    {
        $ok_message = false;
        
        if (!$id && $ids) { // multiple
            if (MailingList::deleteAll(['id' => $ids])) {
                $ok_message = __('Items have been deleted successfully.');
            }
        } elseif ($this->findModel($id)->delete()) { // single
            $ok_message = __('Item has been deleted successfully.');
        }

        if ($ok_message) {
            Yii::$app->session->setFlash('success', $ok_message);
        }

        return $this->redirect(['index']);
    }

    public function actionAppendPartners(array $partner_ids = [])
    {
        $request = Yii::$app->request;
        $model = new MailingListAppendPartner;
        if (
            $request->isPost
            && $model->load($request->post())
            && $model->validate()
        ) {
            if ($model->append()) {
                Yii::$app->session->setFlash('success', __('Your changes have been saved successfully.'));
            }
            if ($request->isAjax) {
                return;
            }
            return $this->redirect(['index']);
        } else {
            $model->partner_ids = implode(',', $partner_ids);
            return $this->renderAjax('appendPartners', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Finds the MailingList model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MailingList the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MailingList::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
