<?php

namespace app\models\query;

class LanguageQuery extends ActiveQuery
{
    public function sorted()
    {
        return $this->orderBy(['name' => SORT_ASC]);
    }

}
