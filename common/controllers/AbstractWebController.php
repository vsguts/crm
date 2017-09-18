<?php

namespace common\controllers;

use common\controllers\behaviors\AjaxFilter;
use common\helpers\FileHelper;
use common\models\AbstractModel;
use Yii;
use yii\base\Exception;
use yii\db\ActiveRecordInterface;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\Controller;

/**
 * Class AbstractController
 * @mixin AjaxFilter
 */
class AbstractWebController extends Controller
{
    protected $notices = [];

    public function init()
    {
        parent::init();
        Yii::$app->session->open();
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'ajax' => [
                'class' => AjaxFilter::class,
            ],
        ];
    }

    /**
     * Substitution render() to renderAjax() for ajax requests
     *
     * @param string $view
     * @param array  $params
     * @return string
     */
    public function render($view, $params = [])
    {
        if ($this->getBehavior('ajax') && $this->getIsAjax()) {
            return $this->renderAjax($view, $params);
        }
        return parent::render($view, $params);
    }

    /**
     * @param array|string $url
     * @param bool         $force
     * @param int          $statusCode
     * @return \yii\web\Response
     */
    public function redirect($url, $force = false, $statusCode = 302)
    {
        $params = $_REQUEST;

        $hash = isset($url['#']) ? $url['#'] : null;

        // Meta redirect
        if (headers_sent() || ob_get_contents()) {
            $url = !empty($params['_return_url']) ? $params['_return_url'] : $url;
            $url = Url::to($url);
            $this->ech(Html::tag('meta', '', ['http-equiv' => 'Refresh', 'content' => '1;URL=' . $url . '']));
            $this->ech(Html::a(__('Continue'), $url));
        }

        if (!empty($params['_return_url']) && !$force) {
            if ($hash) {
                $params['_return_url'] .= '#' . $hash;
            }
            return Yii::$app->getResponse()->redirect($params['_return_url'], $statusCode);
        }

        if ($hash) {
            $url['#'] = $hash;
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
    public function notice($text, $type = 'success')
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
     * @param AbstractModel|AbstractModel[]|string $object Object or class name
     * @param array|int                            $id
     * @param bool                                 $redirect_to_referrer
     * @param string                               $scenario
     * @return \yii\web\Response
     * @throws Exception
     */
    protected function delete($object, $id = null, $redirect_to_referrer = true, $scenario = null)
    {
        // Select

        if ($object instanceof ActiveRecordInterface && !$object->getIsNewRecord()) { // AbstractModel
            $objects = [$object];
        } elseif (is_array($object)) { // AbstractModel[]
            $objects = $object;
        } else { // Class name
            if (!$id) {
                throw new Exception('ID is empty');
            }
            $idField = $object::tableName() . '.' . $object::primaryKey()[0];
            $objects = $object::find()->permission()->andWhere([$idField => $id])->all();
        }

        // Remove and show notice or error

        if ($objects) {
            $status = true;
            foreach ($objects as $object) {
                if ($scenario) {
                    $object->scenario = $scenario;
                }
                if (!$object->delete()) {
                    $status = false;
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
     * @param string $param
     * @return array|mixed
     */
    protected function getRequest($param = 'id')
    {
        return Yii::$app->request->post($param, Yii::$app->request->get($param));
    }
}
