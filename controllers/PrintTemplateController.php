<?php

namespace app\controllers;

use app\models\PrintTemplate;
use app\models\search\PrintTemplateSearch;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

/**
 * PrintTemplateController implements the CRUD actions for PrintTemplate model.
 */
class PrintTemplateController extends AbstractController
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
                        'actions' => ['index', 'update', 'view'],
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
     * Lists all PrintTemplate models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PrintTemplateSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new PrintTemplate model.
     * If creation is successful, the browser will be redirected to the 'update' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PrintTemplate();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', __('Your changes have been saved successfully.'));
            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            $model->validate(['margin_top', 'margin_bottom', 'margin_left', 'margin_right', 'wrapper']);
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing PrintTemplate model.
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

    public function actionView($id, $to_pdf = false)
    {
        $model = $this->findModel($id);

        $this->layout = 'print';
        $html = $this->render('view', ['content' => $model->generate()]);

        if ($to_pdf) {
            $pdf = Yii::$app->htmlToPdf->convert($html, $model->prepareOptions());

            return Yii::$app->response->sendContentAsFile(
                $pdf,
                $model->name . '_' . date('Y-m-d_H:i') . '.pdf',
                ['mimeType' => 'application/pdf']
            );
        }
        
        return $html;
    }

    /**
     * Deletes an existing PrintTemplate model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id = null, array $ids = null)
    {
        $ok_message = false;
        
        if (!$id && $ids) { // multiple
            if (PrintTemplate::deleteAll(['id' => $ids])) {
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
     * Finds the PrintTemplate model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PrintTemplate the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PrintTemplate::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
