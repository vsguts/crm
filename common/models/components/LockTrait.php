<?php

namespace common\models\components;

use yii\base\Exception;

trait LockTrait
{
    protected static $lockPrefix = 'lock_';

    /**
     * @param $name
     * @param bool $errorTrace
     * @return bool
     * @throws Exception
     */
    public static function lock($name, $errorTrace = false)
    {
        $lockVar = self::checkLock($name);

        if (!$lockVar) {
            self::set(static::$lockPrefix . $name, time());
            return false;
        }

        if ($errorTrace) {
            throw new Exception(__(
                'Lock variable: %s is still set. Please try again later.',
                static::$lockPrefix . $name
            ));
        }

        return $lockVar;
    }

    /**
     * @param $name
     * @return bool
     */
    public static function releaseLock($name)
    {
        return self::del(static::$lockPrefix . $name);
    }

    /**
     * Check if lock exists and if it exceeds it's time delete it
     *
     * @param $name
     * @return mixed
     */
    public static function checkLock($name)
    {
        $lockVar = self::get(static::$lockPrefix . $name);
        if ($lockVar && (($lockVar + SECONDS_IN_DAY) < time())) {
            return !self::releaseLock($name);
        }

        return $lockVar;
    }

    /**
     * @return int
     */
    public static function dropLocks()
    {
        return self::deleteAll(['like', 'name', 'lock_%', false]);
    }
}
