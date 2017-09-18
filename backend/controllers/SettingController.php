<?php

namespace backend\controllers;

use common\models\form\SettingsForm;
use Yii;
use yii\filters\AccessControl;

/**
 * StateController implements the CRUD actions for State model.
 */
class SettingController extends AbstractController
{
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['setting_manage'],
                    ],
                ],
            ],
        ]);
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
