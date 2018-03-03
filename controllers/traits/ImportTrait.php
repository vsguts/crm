<?php

namespace app\controllers\traits;

use app\components\import\AbstractImport;
use app\controllers\AbstractWebController;
use app\models\components\FormatterTrait;
use Yii;
use yii\web\UploadedFile;

/**
 * Importing tools for entity controller
 * @package app\controllers\traits
 * @mixin AbstractWebController
 */
trait ImportTrait
{
    use FormatterTrait;

    protected $formatterPath = '@app/components/import/formatter';

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
