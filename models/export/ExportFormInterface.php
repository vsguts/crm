<?php

namespace app\models\export;

use yii\db\QueryInterface;

interface ExportFormInterface
{
    public function getAvailableFormatters();

    public function getAvailableDelimiters();

    public function exportQuery(QueryInterface $query, $download = false);

    public function exportData(array $data, $download = false);

    public function getColumnsSchema();

}
