<?php
/**
 * Copyright (c) 2019. DeParadox LLC
 */

/**
 * Created by PhpStorm.
 * User: PretorDH (Serhii Usik)
 * Date: 06.01.2019
 * Time: 21:54
 */

namespace app\controllers\guest;


use app\common\Factory;
use app\common\Info;
use app\common\View;
use app\config\Forex;

/**
 * Class Currency
 * @package app\controllers\guest
 */
class Currency extends \app\common\Controller implements Forex {
    use Factory;

    /**
     * Text constant for USD symbol
     */
    const USD_SYMBOL = 'USD';
    /**
     * Pattern constant for filtering USD symbols
     */
    const USD_PATTERN = '/'.self::USD_SYMBOL.'.../i';

    /**
     * @var \app\models\Forex|null
     */
    private $forex = null;

    /**
     * Currency constructor.
     */
    public function __construct() {
        parent::__construct();
        $this->forex = self::factory(self::FOREX_DATA_SOURCE);
    }

    /**
     * Public list of tasks
     * @param $page int
     */
    public function showConverter() {
        $symbols = $this->forex->getSymbolsBySign(self::USD_PATTERN);

        $this->response(new View('forms/converter/converter.php', [
            'symbols' => $symbols,
        ]));
    }

    /**
     * Add new task
     */
    public function doConvert() {
        $symbol = filter_input(INPUT_POST, 'toSymbol', FILTER_SANITIZE_STRING);
        $volume = filter_input(INPUT_POST, 'usdVolume', FILTER_SANITIZE_NUMBER_INT);
        $result = $this->forex->convert(self::USD_SYMBOL, $symbol, $volume);
        $result['input'] = $volume;
        $result['to'] = $symbol;

        Info::dump($result);

        $this->responseJSON([
            ['target' => '#convertedValue', 'content' => $result['value']],
            ['target' => '#convertedText', 'content' => new View('components/converter-text.php', $result).''],
        ]);
    }

}