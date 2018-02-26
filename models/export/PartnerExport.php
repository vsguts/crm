<?php

namespace app\models\export;

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
            'State Link' => 'state.name',
            'State' => 'state',
            'City' => 'city',
            'Address' => 'address',
            'Zip/postal code' => 'zipcode',
            'Member' => 'parent.name',
            'Volunteer' => 'Bool:volunteer',
            'Candidate' => 'Bool:candidate',
            'Public tags' => function ($model) {
                return $this->prepareTags($model->publicTags);
            },
            'Personal tags' => function ($model) {
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
