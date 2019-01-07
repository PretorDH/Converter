<?php
/**
 * Created by PhpStorm.
 * User: PretorDH (Serhii Usik)
 * Date: 07.01.2019
 * Time: 12:28
 */

namespace app\models;


use \app\interfaces\Forex as ForexInterface;

/**
 * Abstract class Forex
 * @package app\models
 */
abstract class Forex implements ForexInterface {
    /**
     * Symbols list
     * @var array
     */
    protected $symbols = [];

    /**
     *
     * @param $expression string
     * @return array
     */
    public function getSymbolsBySign($expression) : array {
        $symbolsFilter = function ($value) use ($expression) {
            return preg_match($expression, $value);
        };
        return array_filter($this->getSymbols(), $symbolsFilter);
    }
}