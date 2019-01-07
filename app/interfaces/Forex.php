<?php
/**
 *  @copyright Copyright (c) 2019. DeParadox LLC
 *  @link http://www.deparadox.com/
 *  @license http://www.deparadox.com/license/
 */

/**
 * Created by PhpStorm.
 * User: PretorDH (Serhii Usik)
 * Date: 06.01.2019
 * Time: 10:11
 */

namespace app\interfaces;


/**
 * Interface Forex
 * @package app\interfaces
 */
interface Forex {

    /**
     * @return array
     */
    public function getSymbols() : array;

    /**
     * @param $from
     * @param $to
     * @param $quantity
     * @return array
     */
    public function convert($from, $to, $quantity) : array;
}