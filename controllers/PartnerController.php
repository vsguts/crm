<?php

namespace app\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use app\models\Partner;
use app\models\search\PartnerSearch;
use app\models\Tag;
use app\models\PrintTemplate;
use app\models\search\VisitSearch;
use app\models\search\DonateSearch;
use app\models\search\TaskSearch;

/**
 * PartnerController implements the CRUD actions for Partner model.
 */
class PartnerController extends AController
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
                        'actions' => ['index', 'list', 'update'],
                        'roles' => ['partner_view'],
                    ],
                    [
                        'allow' => true,
                        'verbs' => ['POST'],
                        'roles' => ['partner_manage'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create'],
                        'verbs' => ['GET'],
                        'roles' => ['partner_manage'],
                    ],
                ],
            ],
            'ajax' => [
                'class' => 'app\behaviors\AjaxFilter',
            ],
        ];
    }

    /**
     * Lists all Partner models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PartnerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        // $this->ajaxAssign('tags', Tag::find()->asArray()->publicTags()->all());
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'tags' => [
                __('Public tags') => Tag::find()->publicTags()->all(),
                __('Personal tags') => Tag::find()->personalTags()->all(),
            ],
        ]);
    }

    /**
     * Ajax handler
     * 
     * @param  string  $q             Query
     * @param  boolean $organizations Include organizations flag
     * @return mixed
     */
    public function actionList($q, $organizations = false)
    {
        $partners = [];
            
        if ($q) {
            $query = Partner::find();
            
            if ($organizations) {
                $query->organizations();
            }
            
            $query->andWhere([
                'or',
                ['like', 'name', $q],
                ['like', 'city', $q],
            ]);

            $models = $query->limit(30)->all();
            foreach ($models as $model) {
                $partners[] = [
                    'id'   => $model->id,
                    'text' => $model->extendedName,
                ];
            }
        }

        $this->ajaxAssign('partners', $partners);
    }

    /**
     * Creates a new Partner model.
     * If creation is successful, the browser will be redirected to the 'update' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Partner();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', __('Your changes has been saved successfully.'));
            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Partner model.
     * If update is successful, the browser will be redirected to the 'update' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', __('Your changes has been saved successfully.'));
            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            $model->prepareTags();

            $visitsDataProvider = (new VisitSearch())->search(['partner_id' => $id]);
            $donatesDataProvider = (new DonateSearch())->search(['partner_id' => $id]);
            $tasksDataProvider = (new TaskSearch())->search(['partner_id' => $id]);
            $contactsDataProvider = (new PartnerSearch())->search(['parent_id' => $id]);
            
            return $this->render('update', [
                'model' => $model,
                'extra' => [
                    'visitsDataProvider'   => $visitsDataProvider,
                    'donatesDataProvider'  => $donatesDataProvider,
                    'tasksDataProvider'    => $tasksDataProvider,
                    'contactsDataProvider' => $contactsDataProvider,
                ],
            ]);
        }
    }

    /**
     * Deletes an existing Partner model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id = null, array $ids = null)
    {
        $ok_message = false;
        
        if (!$id && $ids) { // multiple
            if (Partner::deleteAll(['id' => $ids])) {
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

    public function actionMap(array $ids)
    {
        $models = Partner::findAll(['id' => $ids]);
        
        return $this->render('map', [
            'models' => $models
        ]);
    }

    /**
     * Finds the Partner model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Partner the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Partner::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
