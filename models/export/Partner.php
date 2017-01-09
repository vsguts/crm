<?php

namespace app\models\export;

use app\models\Partner as PartnerModel;
use app\models\search\PartnerSearch;

class Partner extends AbstractExport
{

    public function find()
    {
        if ($this->ids) {
            return PartnerModel::find()
                ->where(['id' => $this->ids])
                ->orderBy(['created_at' => SORT_DESC])
            ;
        } else {
            $search = new PartnerSearch();
            $dataProvider = $search->search($this->queryParams);
            $dataProvider->pagination = false;
            return $dataProvider->query;
        }
    }

    protected function getColumnsDirect()
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
            'Public tags' => 'Callback:publicTags',
            'Personal tags' => 'Callback:personalTags',
            'Notes' => 'notes',
        ];
    }

    public function publicTags($model)
    {
        return $this->prepareTags($model->publicTags);
    }

    public function personalTags($model)
    {
        return $this->prepareTags($model->personalTags);
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
