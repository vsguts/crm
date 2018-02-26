<?php

namespace app\controllers\traits;

use app\models\report\ReportInterface;
use app\controllers\AbstractWebController;
use app\models\export\ExportFormAbstract;
use Yii;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;


/**
 * Exporting tools for report controller
 *
 * You need to enable access to 'export-download' action
 *
 * @package app\controllers\traits
 *
 * @mixin AbstractWebController
 */
trait ExportReportTrait
{

    protected function performExport(ExportFormAbstract $model, ReportInterface $searchModel, $getPath = false)
    {
        $model->validate();

        $post = Yii::$app->request->post();
        if (($post && !empty($post['export_form'])) || $getPath) {
            $model->load($post);

            $data = $searchModel->report(Yii::$app->request->queryParams);
            $path = $model->exportData($data);
            if ($getPath) {
                return $path;
            } elseif ($this->getIsAjax()) {
                $url = Url::to(['export-download', 'path' => Yii::$app->security->encryptDataToString($path)]);
                return $this->ajaxAssign('redirect_url', $url);
            } else {
                return $this->download($path);
            }
        }

        return $this->render('/common/export', [
            'model' => $model,
        ]);
    }

    public function actionExportDownload($path)
    {
        $path = Yii::$app->security->decryptDataFromString($path);
        if (!$path) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        return $this->download($path);
    }

}
