<?php

namespace app\controllers;

use app\controllers\behaviors\AjaxFilter;
use app\controllers\traits\ExportTrait;
use app\models\export\PartnerExport;
use app\models\Partner;
use app\models\search\DonateSearch;
use app\models\search\PartnerSearch;
use app\models\search\TaskSearch;
use app\models\search\CommunicationSearch;
use app\models\Tag;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

/**
 * PartnerController implements the CRUD actions for Partner model.
 */
class PartnerController extends AbstractController
{
    use ExportTrait;

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
                        'actions' => ['index', 'list', 'update'],
                        'roles' => ['partner_view', 'partner_view_own'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['export', 'export-download'],
                        'roles' => ['partner_view', 'partner_view_own'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['partner_manage', 'partner_manage_own'],
                    ],
                ],
            ],
            'ajax' => [
                'class' => AjaxFilter::class,
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

        $tags = [];
        if ($publicTags = Tag::find()->publicTags()->permission()->all()) {
            $tags[__('Public tags')] = $publicTags;
        }
        if ($personalTags = Tag::find()->personalTags()->all()) {
            $tags[__('Personal tags')] = $personalTags;
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'tags' => $tags,
        ]);
    }

    /**
     * Ajax handler
     * @param  string  $q             Query
     * @param string|array $scope
     * @return mixed
     */
    public function actionList($q, $scope = null)
    {
        $partners = [];
            
        if ($q) {
            $query = Partner::find()
                ->permission()
                ->scope($scope)
                ->andWhere([
                    'or',
                    ['like', 'name', $q],
                    ['like', 'city', $q],
                ])
                ->limit(30);

            /** @var Partner $model */
            foreach ($query->all() as $model) {
                $partners[] = [
                    'id'   => $model->id,
                    'text' => $model->getExtendedName(),
                ];
            }
        }

        $this->ajaxAssign('list', $partners);
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
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id, Partner::class);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', __('Your changes have been saved successfully.'));
            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            $model->prepareTags();

            $communicationsDataProvider = (new CommunicationSearch())->search(['partner_id' => $id]);
            $donatesDataProvider = (new DonateSearch())->search(['partner_id' => $id]);
            $tasksDataProvider = (new TaskSearch())->search(['partner_id' => $id]);
            $contactsDataProvider = (new PartnerSearch())->search(['parent_id' => $id]);
            
            return $this->render('update', [
                'model' => $model,
                'extra' => [
                    'communicationsDataProvider'   => $communicationsDataProvider,
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
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete(array $id)
    {
        $models = Partner::find()->id($id)->permission()->all();
        $status = true;

        if ($models) {
            $status = true;
            foreach ($models as $model) {
                if ($model->canManage()) {
                    if (!$model->delete()) {
                        $status = false;
                    }
                } else {
                    $status = false;
                }
            }

            if ($status) {
                if (count($models) > 1) {
                    $this->notice(__('Items have been deleted successfully.'));
                } else {
                    $this->notice(__('Item has been deleted successfully.'));
                }
            } else {
                $model = reset($models);
                if ($model->errors) {
                    $this->notice($model->errors, 'danger');
                    $status = false;
                } else {
                    if (count($models) > 1) {
                        $this->notice(__("Items can't be deleted."), 'danger');
                    } else {
                        $this->notice(__("Item can't be deleted."), 'danger');
                    }
                }
            }
        }

        if (!$status && count($models) === 1) {
            return $this->redirect(['update', 'id' => reset($id)]);
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

    public function actionExport()
    {
        return $this->performExport(
            new PartnerExport(),
            (new PartnerSearch())->search(Yii::$app->request->queryParams)
        );
    }
}
