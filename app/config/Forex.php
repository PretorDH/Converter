<?php
/**
 *  @copyright Copyright (c) 2018. DeParadox LLC
 *  @link http://www.deparadox.com/
 *  @license http://www.deparadox.com/license/
 */

/**
 * Created by PhpStorm.
 * User: PretorDH (Serhii Usik)
 * Date: 06.01.2019
 * Time: 10:11
 */

namespace app\config;


use app\models\OneForgeForexAdaptor;

/**
 * Interface Forex
 * @package app\config
 */
interface Forex {

    /**
     * Adapted class name with forex interface
     */
    const FOREX_DATA_SOURCE = OneForgeForexAdaptor::class;

    /**
     * One forge API key
     */
    const ONE_FORGE_API_KEY = 'zEnvIn4pDM4Hg9j9zTyLVwpDdAC4GXFL';
}