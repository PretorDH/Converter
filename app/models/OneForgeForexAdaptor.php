<?php
/**
 * Created by PhpStorm.
 * User: PretorDH (Serhii Usik)
 * Date: 07.01.2019
 * Time: 0:08
 */

namespace app\models;


use \app\config\Forex as ForexConfig;
use app\common\Factory;
use OneForge\ForexQuotes\ForexDataClient;

/**
 * Class Adaptor for OneForgeForex forex data provider
 * @package app\models
 */
class OneForgeForexAdaptor extends Forex implements ForexConfig {
    use Factory;

    /**
     * Forex data source class
     */
    const DATA_SOURCE = ForexDataClient::class;

    /**
     * Instance of forex data source
     * @var object|null
     */
    private $dataSource = null;

    /**
     * Forex constructor.
     * @param string $api_key
     */
    public function __construct($api_key = self::ONE_FORGE_API_KEY) {
        $this->dataSource = self::factory(self::DATA_SOURCE, [$api_key]);
    }

    /**
     * Get currency symbols from API
     * @return array
     */
    public function getSymbols() : array {
        $this->symbols = $this->dataSource->getSymbols();
        return $this->symbols;
    }

    /**
     * @param $from
     * @param $to
     * @param $quantity
     * @return array
     */
    public function convert($from, $to, $quantity) : array {
        return $this->dataSource->convert($from, $to, $quantity);
    }
}