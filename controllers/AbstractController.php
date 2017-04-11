<?php

namespace app\controllers;

use app\controllers\behaviors\AjaxFilter;
use app\helpers\FileHelper;
use app\models\Language;
use Yii;
use yii\base\Exception;
use yii\db\ActiveQueryInterface;
use yii\db\ActiveRecordInterface;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Cookie;
use yii\web\NotFoundHttpException;

class AbstractController extends Controller
{
    protected $notices = [];

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

    public function behaviors()
    {
        return [
            'ajax' => [
                'class' => AjaxFilter::class,
            ],
        ];
    }

    public function redirect($url, $force = false, $statusCode = 302)
    {
        $params = $_REQUEST;

        // Meta redirect
        if (headers_sent() || ob_get_contents()) {
            $url = !empty($params['_return_url']) ? $params['_return_url'] : $url;
            $url = Url::to($url);
            $this->ech(Html::tag('meta', '', ['http-equiv' => 'Refresh', 'content' => '1;URL=' . $url . '']));
            $this->ech(Html::a(__('Continue'), $url));
        }

        if (!empty($params['_return_url']) && !$force) {
            return Yii::$app->getResponse()->redirect($params['_return_url'], $statusCode);
        }

        return parent::redirect($url, $statusCode);
    }

    protected function startLongProcess()
    {
        set_time_limit(0);
        ob_start('ob_gzhandler');
    }

    protected function ech($string)
    {
        echo($string);
        ob_flush();
    }

    /**
     * Send notice
     * @param  mixed $text Text
     * @param  string $type text|danger|info|warning
     */
    protected function notice($text, $type = 'success')
    {
        if (is_array($text)) {
            foreach ($text as $_text) {
                $this->notice($_text, $type);
            }
        } else {
            $cash_key = md5($type . '_' . $text);
            if (isset($this->notices[$cash_key])) {
                return;
            }
            $this->notices[$cash_key] = true;

            Yii::$app->session->addFlash($type, $text);

            // Ajax workaround
            if ($this->getIsAjax()) {
                $this->ajaxAssign('alerts', Yii::$app->session->getAllFlashes());
            }
        }
    }

    /**
     * @param object|string $object Object or class name
     * @param array|int $id
     * @param bool $redirect_to_referrer
     * @return \yii\web\Response
     * @throws Exception
     */
    protected function delete($object, $id, $redirect_to_referrer = true)
    {
        // Select

        if ($object instanceof ActiveRecordInterface && !$object->getIsNewRecord()) {
            $objects = [$object];
        } else {
            if (!$id) {
                throw new Exception('ID is empty');
            }
            $id_field = $object::tableName() . '.' . $object::primaryKey()[0];
            $objects = $object::find()->permission()->andWhere([$id_field => $id])->all();
        }

        // Remove and show notice or error

        if ($objects) {
            $status = true;
            foreach ($objects as $object) {
                if (!$object->delete()) {
                    $status = false;
                    break;
                }
            }

            if ($status) {
                if (count($objects) > 1) {
                    $this->notice(__('Items have been deleted successfully.'));
                } else {
                    $this->notice(__('Item has been deleted successfully.'));
                }
            } else {
                $object = reset($objects);
                if ($object->errors) {
                    $this->notice($object->errors, 'danger');
                } else {
                    if (count($objects) > 1) {
                        $this->notice(__("Items can't be deleted."), 'danger');
                    } else {
                        $this->notice(__("Item can't be deleted."), 'danger');
                    }
                }
            }
        } else {
            $this->notice(__("Not found."), 'danger');
        }

        // Redirect

        if (
            $redirect_to_referrer
            && $referrer = Yii::$app->request->referrer
        ) {
            return $this->redirect($referrer);
        }

        return $this->redirect(['index']);
    }

    protected function download($path, $display_if_can = true)
    {
        $pos = strrpos($path, '/');
        $filename = substr($path, $pos + 1);

        if ($display_if_can && FileHelper::canShow($path)) {
            return Yii::$app->response->sendFile($path, $filename, ['inline' => true]);
        }

        return Yii::$app->response->sendFile($path, $filename);
    }

    /**
     * Finds a model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id     Primary key
     * @param string  $object Model class
     * @return mixed the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id, $object = null)
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
            $model = $query->andWhere([$field => $id])->permission()->one();
            if ($model) {
                return $model;
            }
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * @param string $param
     * @return array|mixed
     */
    protected function getRequest($param = 'id')
    {
        return Yii::$app->request->post($param, Yii::$app->request->get($param));
    }
}
