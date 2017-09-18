<?php

namespace common\models\components;

trait AttributeCheckerTrait
{
    public $roundPrecision = 2;

    /**
     * @param $field
     * @param $attributes
     * @param $oldAttributes
     * @return bool
     */
    protected function isChanged($field, $attributes = null, $oldAttributes = null)
    {
        $attributes = $attributes ?? $this->owner->getAttributes();
        $oldAttributes = $oldAttributes ?? $this->owner->getOldAttributes();
        if (isset($attributes[$field]) || isset($oldAttributes[$field])) {
            $values = [
                $attributes[$field],
                $oldAttributes[$field],
            ];
            foreach ($values as & $value) {
                $this->prepareValue($value);
            }
            return $values[0] != $values[1];
        }
        return false;
    }

    /**
     * @param $value
     * @return float
     */
    protected function prepareValue($value)
    {
        if (is_numeric($value)) {
            return round(floatval($value), $this->roundPrecision);
        }

        return $value;
    }
}
