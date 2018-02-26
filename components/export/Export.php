<?php

namespace app\components\export;

use app\helpers\Classes;
use yii\base\Component;
use yii\base\Model;

class Export extends Component
{
    private $formatterClass = '\app\components\export\formatter\Xlsx';

    private $data;

    private $columns;

    private $filename = 'export';


    public static function getFormatters()
    {
        return Classes::getNamespaceClasses('@app/components/export/formatter');
    }

    /**
     * @param string $formatterClass
     * @return Export
     */
    public function setFormatterClass(string $formatterClass): Export
    {
        $this->formatterClass = $formatterClass;
        return $this;
    }

    /**
     * @param mixed $data
     * @return Export
     */
    public function setData($data): Export
    {
        $this->data = $data;
        return $this;
    }

    /**
     * @param mixed $columns
     * @return Export
     */
    public function setColumns($columns): Export
    {
        $this->columns = $columns;
        return $this;
    }

    /**
     * @param string $filename
     * @return Export
     */
    public function setFilename(string $filename): Export
    {
        $this->filename = $filename;
        return $this;
    }

    /**
     * @param bool $download
     * @return string File path
     */
    public function export($download = false)
    {
        if (!$this->columns) {
            $firstItem = reset($data);
            $this->columns = array_keys($firstItem);
        }

        /** @var \app\components\export\formatter\AbstractFormatter $formatter */
        $formatter = \Yii::createObject([
            'class' => $this->formatterClass,
            'columns' => $this->columns,
            'data' => $this->data,
        ]);

        if ($this->filename) {
            $formatter->filename = $this->filename;
        }

        return $formatter->export($download);
    }

    /**
     * @param array|Model[] $models
     * @param array $columnSchema
     * @return Export
     */
    public function prepareData($models, $columnSchema): Export
    {
        $data = [];

        foreach ($models as $model) {
            $row = [];
            foreach ($columnSchema as $column => $field) {
                $value = '';
                if ($field instanceof \Closure) {
                    $value = $field($model);
                } else {
                    @list($field, $format) = explode('|', $field, 2);
                    if (strpos($field, 'Lookup:') === 0) { // Lookup
                        list(, $field) = explode(':', $field, 2);
                        $value = $this->getLookupItem($model, $field);
                    } elseif (strpos($field, 'Bool:') === 0) { // Boolean
                        list(, $field) = explode(':', $field, 2);
                        $value = $model->$field ? 'Yes' : 'No';
                    } elseif (strpos($field, '.') && strpos($field, ':')) { // relation
                        list($field, $relation_data) = explode(':', $field, 2);
                        list($entity, $entityField) = explode('.', $relation_data, 2);
                        $variants = $this->getList($entity, $entityField);
                        if ($variantKey = $this->getModelValue($model, $field)) {
                            $value = $variants[$variantKey];
                        }
                    } else { // just field
                        $value = $this->getModelValue($model, $field);
                    }

                    // Formatter
                    if ($format) {
                        $method = 'as' . ucfirst($format);
                        $value = \Yii::$app->formatter->$method($value);
                    }
                }

                $row[$column] = $value;
            }
            $data[] = $row;
        }

        $this
            ->setColumns(array_keys($columnSchema))
            ->setData($data);

        return $this;
    }

    protected function getModelValue($model, $field)
    {
        $parts = explode('.', $field);
        $result = $model;
        foreach ($parts as $part) {
            if (is_object($result) && isset($result->$part)) {
                $result = $result->$part;
            } elseif (is_array($result) && isset($result[$part])) {
                $result = $result[$part];
            } else {
                $result = null;
                break;
            }
        }

        return $result;
    }

    protected function getModelField($model, $field)
    {
        $parts = explode('.', $field);
        $object = null;
        $field = null;
        $result = $model;
        foreach ($parts as $part) {
            $object = $result;
            $field = $part;
            if (is_object($result) && isset($result->$part)) {
                $result = $result->$part;
            } elseif (is_array($result) && isset($result[$part])) {
                $result = $result[$part];
            } else {
                break;
            }
        }

        return [$object, $field];
    }

    protected function getList($class, $field = null)
    {
        static $cache = [];

        $key = $class . $field;
        if (!isset($cache[$key])) {
            if (!class_exists($class)) {
                $class = 'app\\models\\' . $class;
            }
            $options = [];
            if ($field) {
                $options['field'] = $field;
            }
            $cache[$key] = $class::find()->scroll($options);
        }

        return $cache[$key];
    }

    protected function getLookupItem($model, $field)
    {
        list($object, $field) = $this->getModelField($model, $field);
        return $object->getLookupItem($field);
    }

}
