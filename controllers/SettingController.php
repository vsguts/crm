<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\form\SettingsForm;

/**
 * StateController implements the CRUD actions for State model.
 */
class SettingController extends AbstractController
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['setting_manage'],
                    ],
                ],
            ],
            'ajax' => [
                'class' => 'app\behaviors\AjaxFilter',
            ],
        ];
    }

    /**
     * Lists all State models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new SettingsForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->saveSettings();
            Yii::$app->session->setFlash('success', __('Your changes have been saved successfully.'));
            return $this->redirect(['index']);
        } else {
            return $this->render('index', [
                'model' => $model,
            ]);
        }
    }

}
