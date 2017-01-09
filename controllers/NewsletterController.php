<?php

namespace app\controllers;

use Yii;
use app\models\Newsletter;
use app\models\NewsletterLog;
use app\models\MailingList;
use app\models\search\NewsletterSearch;
use app\models\search\NewsletterLogSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * NewsletterController implements the CRUD actions for Newsletter model.
 */
class NewsletterController extends AbstractController
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'send' => ['post'],
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
                        'verbs' => ['POST'],
                        'roles' => ['newsletter_manage'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create'],
                        'verbs' => ['GET'],
                        'roles' => ['newsletter_manage'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Newsletter models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new NewsletterSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Newsletter model.
     * If creation is successful, the browser will be redirected to the 'update' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Newsletter();

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
     * Updates an existing Newsletter model.
     * If update is successful, the browser will be redirected to the 'update' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id, Newsletter::className());

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', __('Your changes have been saved successfully.'));
            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            $logSearch = array_merge(Yii::$app->request->queryParams, ['newsletter_id' => $id]);
            unset($logSearch['id']);
            return $this->render('update', [
                'model'     => $model,
                'logSearch' => (new NewsletterLogSearch())->search($logSearch),
            ]);
        }
    }

    /**
     * Deletes an existing Newsletter model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @param array   $ids
     * @return mixed
     */
    public function actionDelete($id = null, array $ids = null)
    {
        $ok_message = false;
        
        if (!$id && $ids) { // multiple
            if (Newsletter::deleteAll(['id' => $ids])) {
                $ok_message = __('Items have been deleted successfully.');
            }
        } elseif ($this->findModel($id, Newsletter::className())->delete()) { // single
            $ok_message = __('Item has been deleted successfully.');
        }

        if ($ok_message) {
            Yii::$app->session->setFlash('success', $ok_message);
        }

        return $this->redirect(['index']);
    }

    public function actionLogDelete($newsletter_id, array $ids = null)
    {
        if ($newsletter_id && $ids && NewsletterLog::deleteAll(['newsletter_id' => $newsletter_id, 'id' => $ids])) {
            Yii::$app->session->setFlash('success', __('Items have been deleted successfully.'));
        }

        return $this->redirect(['update', 'id' => $newsletter_id]);
    }

    public function actionSend($id)
    {
        $model = $this->findModel($id, Newsletter::className());
        $errors = $model->send(true);
        if (empty($errors)) {
            Yii::$app->session->setFlash('success', __('The newsletter have been sent successfully.'));
        } else {
            Yii::$app->session->setFlash('error', reset($errors));
        }
        return $this->redirect(['update', 'id' => $id]);
    }

}
