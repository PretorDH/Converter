<?php
/**
 * Created by PhpStorm.
 * User: PretorDH (Serhii Usik)
 * Date: 06.01.2019
 * Time: 20:14
 */

namespace app\common;


/**
 * Trait Factory
 * @package app\common
 */
trait Factory {
    /**
     * Create new instance of class
     *
     * @param $class
     * @param array $arguments
     * @return mixed
     */
    public static function factory($class = self::class, $arguments = [] ) {
        return new $class(...$arguments);
    }
}