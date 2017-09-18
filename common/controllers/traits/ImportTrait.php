<?php

namespace common\controllers\traits;

use backend\models\import\AbstractImport;
use common\controllers\AbstractWebController;
use common\models\components\FormatterTrait;
use Yii;
use yii\web\UploadedFile;


/**
 * Importing tools for entity controller
 * @package common\controllers\traits
 * @mixin AbstractWebController
 */
trait ImportTrait
{
    use FormatterTrait;

    protected $formatterPath = '@backend/models/import/formatter';

    public function performImport(AbstractImport $model, array $attributes = [])
    {
        $this->startLongProcess();

        if ($attributes) { // Extra params
            $model->setAttributes($attributes, false);
        }

        if ($post = Yii::$app->request->post()) {
            $model->load($post);
            if ($file = UploadedFile::getInstance($model, 'upload')) {
                if ($imported = $model->import($file->tempName)) {
                    $this->notice(__('{num} items were imported.', ['num' => $imported]));
                }
            }
            return $this->redirect(['index']);
        }

        return $this->render('/common/import', [
            'model' => $model,
            'formatters' => $this->getFormatters(),
        ]);
    }

}
