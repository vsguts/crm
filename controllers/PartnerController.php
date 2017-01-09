<?php

namespace app\controllers;

use app\models\Partner;
use app\models\search\DonateSearch;
use app\models\search\PartnerSearch;
use app\models\search\TaskSearch;
use app\models\search\VisitSearch;
use app\models\Tag;
use Yii;

/**
 * PartnerController implements the CRUD actions for Partner model.
 */
class PartnerController extends AbstractController
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
                        'roles' => ['partner_view', 'partner_view_own'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['partner_manage', 'partner_manage_own'],
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
            Yii::$app->session->setFlash('success', __('Your changes have been saved successfully.'));
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
        $model = $this->findModel($id, Partner::className());

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', __('Your changes have been saved successfully.'));
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
     * @param array|int $id
     * @return mixed
     */
    public function actionDelete(array $id)
    {
        $models = Partner::find()->where(['partner.id' => $id])->permission()->all();
        if ($models) {
            foreach ($models as $model) {
                if ($model->canManage()) {
                    $model->delete();
                }
            }

            if (count($models) > 1) {
                $this->notice(__('Items have been deleted successfully.'));
            } else {
                $this->notice(__('Item has been deleted successfully.'));
            }
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

}
