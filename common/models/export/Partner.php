<?php

namespace common\models\export;

use common\models\Partner as PartnerModel;
use common\models\search\PartnerSearch;

class Partner extends AbstractExport
{

    public function find()
    {
        if ($this->ids) {
            return PartnerModel::find()
                ->where(['id' => $this->ids])
                ->orderBy(['id' => SORT_DESC])
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
            'Communication method' => 'Lookup:communication_method',
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

    private function prepareTags($tags)
    {
        $result = [];
        foreach ($tags as $tag) {
            $result[] = $tag->name;
        }
        return implode(',', $result);
    }

}
