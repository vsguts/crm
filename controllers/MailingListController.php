<?php

namespace app\controllers;

use app\controllers\behaviors\AjaxFilter;
use app\models\form\MailingListAppendPartner;
use app\models\MailingList;
use app\models\search\MailingListSearch;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

/**
 * MailingListController implements the CRUD actions for MailingList model.
 */
class MailingListController extends AbstractController
{
    public function behaviors()
    {
        return [
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
                        'roles' => ['mailing_list_view'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['mailing_list_manage'],
                    ],
                ],
            ],
            'ajax' => [
                'class' => AjaxFilter::class,
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
        $model = $this->findModel($id, MailingList::class);

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
        } elseif ($this->findModel($id, MailingList::class)->delete()) { // single
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

}
