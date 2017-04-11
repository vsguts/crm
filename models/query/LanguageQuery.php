<?php

namespace app\models\query;

class LanguageQuery extends ActiveQuery
{
    public function sorted($sort = SORT_ASC)
    {
        return $this->orderBy(['name' => $sort]);
    }

}
