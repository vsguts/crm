<?php

namespace app\models\export;

use app\components\export\Export;
use app\helpers\Classes;
use yii\base\Model;
use yii\db\QueryInterface;
use yii\helpers\Inflector;

abstract class ExportFormAbstract extends Model implements ExportFormInterface
{
    /**
     * Formatter name: csv or xls
     * @var [type]
     */
    public $formatter;

    /**
     * Export file name
     * @var string
     */
    public $filename;

    /**
     * CSV delimiter
     * @var string
     */
    public $delimiter;

    /**
     * Object IDs
     * @var array
     */
    public $ids = [];

    /**
     * Flag ajax is enabled
     * @var bool
     */
    public $enableAjax = true;

    public function rules()
    {
        return [
            // Defaults
            [['formatter'], 'default', 'value' => 'app\components\export\formatter\Xlsx'],
            [['filename'], 'default', 'value' => Inflector::underscore(Classes::className($this)) . '_' . date('Y-m-d_H-i')],

            // Common
            [['formatter', 'filename'], 'required'],
            [['delimiter'], 'string'],
            [['ids'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'filename'  => __('Filename'),
            'formatter' => __('Format'),
            // CSV
            'delimiter' => __('Delimiter'),
        ];
    }

    public function getAvailableFormatters()
    {
        return Export::getFormatters();
    }

    public function getAvailableDelimiters()
    {
        return [
            ';' => __('Semicolon'),
            ',' => __('Comma'),
        ];
    }

    public function exportQuery(QueryInterface $query, $download = false)
    {
        $query = $this->prepareQuery($query);
        return $this->export($query->all(), $download);
    }

    public function exportData(array $data, $download = false)
    {
        $data = $this->prepareData($data);
        return $this->export($data, $download);
    }

    private function export($data, $download)
    {
        $export = new Export;
        $path = $export
            ->setFormatterClass($this->formatter)
            ->setFilename($this->filename)
            ->prepareData($data, $this->getColumnsSchema())
            ->export($download);

        return $path;
    }

    protected function prepareData($data)
    {
        return $data;
    }

    /**
     * @param QueryInterface $query
     * @return QueryInterface
     */
    protected function prepareQuery(QueryInterface $query)
    {
        return $query;
    }

}
