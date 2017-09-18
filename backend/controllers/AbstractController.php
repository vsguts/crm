<?php

namespace backend\controllers;

use common\controllers\AbstractWebController;
use common\models\Language;
use Yii;
use yii\db\ActiveQueryInterface;
use yii\web\Cookie;
use yii\web\NotFoundHttpException;

/**
 * Class AbstractController
 */
abstract class AbstractController extends AbstractWebController
{

    public function init()
    {
        parent::init();

        Yii::$app->session->open();

        $language = Yii::$app->request->cookies->getValue('language');
        if ($language && strlen($language) == 5) {
            Yii::$app->language = $language;
        } else {
            if (!empty($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
                $languages = Language::find()->sorted()->all();
                $codes = [];
                foreach ($languages as $language) {
                    $codes[] = $language->code;
                }
                if (preg_match("/(" . implode('|' , $codes) . ")+(-|;|,)?(.*)?/", $_SERVER['HTTP_ACCEPT_LANGUAGE'], $matches)) {
                    $browser_language = $matches[1];
                    Yii::$app->response->cookies->add(new Cookie([
                        'name' => 'language',
                        'value' => $browser_language,
                        'expire' => (new \Datetime)->modify('+1 year')->getTimestamp(),
                    ]));
                    Yii::$app->language = $browser_language;
                }
            }
        }
    }

    /**
     * Finds a model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id     Primary key
     * @param string  $object Model class
     * @param null    $permission
     * @return mixed the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id, $object = null, $permission = null)
    {
        if ($object instanceof ActiveQueryInterface) {
            $query = $object;
            $object = $object->modelClass;
        } else {
            $query = $object::find();
        }

        if ($pks = $object::primaryKey()) {
            $tableName = $object::tableName();
            $field = $tableName . '.' . $pks[0];
            if ($permission) {
                $query->permission($permission);
            } else {
                $query->permission();
            }
            $model = $query->andWhere([$field => $id])->one();
            if ($model) {
                return $model;
            }
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
