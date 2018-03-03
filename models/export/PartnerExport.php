<?php

namespace app\models\export;

use app\models\Partner;

class PartnerExport extends ExportFormAbstract
{
    public function getColumnsSchema()
    {
        return [
            'ID' => 'id',
            'Type' => 'Lookup:type',
            'Status' => 'Lookup:status',
            'Name' => 'name',
            'First name' => 'firstname',
            'Last name' => 'lastname',
            'Contact person' => 'contact',
            'Email' => 'email',
            'Phone' => 'phone',
            'Country' => 'country.name',
            'State' => function (Partner $model) {
                $states = \Yii::$app->states->getStatesByCountries();
                if ($model->state_id && $model->country_id && isset($states[$model->country_id])) {
                    // pd($states[$model->country_id], $model->state_id);
                    return $states[$model->country_id][$model->state_id]->name ?? '';
                }
                return $model->state;
            },
            'City' => 'city',
            'Address' => 'address',
            'Zip/postal code' => 'zipcode',
            'Member' => 'parent.name',
            'Volunteer' => 'Bool:volunteer',
            'Candidate' => 'Bool:candidate',
            'Public tags' => function (Partner $model) {
                return $this->prepareTags($model->publicTags);
            },
            'Personal tags' => function (Partner $model) {
                return $this->prepareTags($model->personalTags);
            },
            'Notes' => 'notes',
            'Communication method' => 'Lookup:communication_method',
        ];
    }

    protected function prepareTags($tags)
    {
        $result = [];
        foreach ($tags as $tag) {
            $result[] = $tag->name;
        }
        return implode(',', $result);
    }
}
