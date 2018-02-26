<?php

namespace app\controllers\traits;

use app\models\export\ExportFormAbstract;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;


/**
 * Exporting tools for entity controller
 *
 * You need to enable access to 'export-download' action
 *
 * @package app\controllers\traits
 */
trait ExportTrait
{

    public function performExport(ExportFormAbstract $model, ActiveDataProvider $dataProvider)
    {
        $model->validate();

        $ids = $this->getRequest('ids');
        if ($ids) {
            $model->ids = $ids;
        }

        $post = Yii::$app->request->post();
        if ($post && !empty($post['export_form'])) {
            $model->load($post);

            if ($sort = $dataProvider->getSort()) {
                $sort->params = Yii::$app->request->queryParams;
                $dataProvider->query->addOrderBy($sort->getOrders());
            }
            if ($ids) {
                $dataProvider->query->andWhere([$dataProvider->query->modelClass::tableName() . '.id' => $ids]);
            }

            $path = $model->exportQuery($dataProvider->query);

            if ($this->getIsAjax()) {
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
