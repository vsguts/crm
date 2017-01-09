<?php

namespace app\controllers;

use Yii;
use yii\web\ForbiddenHttpException;
use app\models\Attachment;

class AttachmentController extends AbstractController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => 'yii\filters\VerbFilter',
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionDelete($id, $_return_url = null)
    {
        $model = $this->findModel($id, Attachment::className());
        $this->checkPermission($model, true);
        if ($model->delete()) {
            if ($model->object) {
                $model->object->updateHasAttachmentsFlags();
            }
            Yii::$app->session->setFlash('success', __('Item has been deleted successfully.'));
        }
        return $this->redirect($_return_url);
    }

    public function actionDownload($id)
    {
        $model = $this->findModel($id, Attachment::className());
        $this->checkPermission($model);
        return $this->download($model->getPath());
    }


    protected function checkPermission($model, $manage = false)
    {
        $suffix = $manage ? 'manage' : 'view';
        $perm = $model->table . '_' . $suffix;
        if (!Yii::$app->user->can($perm)) {
            throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
        }
    }

}
