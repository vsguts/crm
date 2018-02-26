<?php

namespace app\components\app;

use app\models\State;
use yii\di\ServiceLocator;

class States extends ServiceLocator
{
    private $states;

    public function getStates()
    {
        if (is_null($this->states)) {
            $this->states = State::find()->orderBy('name asc')->all();
        }
        return $this->states;
    }

    public function getStatesByCountries()
    {
        $byCountries = [];
        foreach ($this->getStates() as $state) {
            $byCountries[$state->country_id][$state->id] = $state;
        }
        return $byCountries;
    }

}
