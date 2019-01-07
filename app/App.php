<?php
/**
 * Copyright (c) 2019. DeParadox LLC
 */

/**
 * Created by PhpStorm.
 * User: PretorDH
 * Date: 06.01.2019
 * Time: 12:16
 */

namespace app;

use app\controllers\Errors;

/**
 * Class App Application core class
 * @package app
 */
class App implements config\App {
    /**
     * Legal app call flag
     * @var
     */
    private $legal;

    /**
     * Instance of application bootstrap components
     * @var Bootstrap
     */
    private $bootstrap;

    /**
     * App constructor.
     * @param $legal
     */
    public function __construct($legal = false) {
        $this->legal = $legal;
        $this->bootstrap = new Bootstrap();

        $this->run();
    }

    /**
     * Check direct access classes
     */
    private function run() {
        if (defined('APP_LEGAL') && APP_LEGAL && $this->legal === APP_LEGAL) {
            $this->bootstrap->run();
        } else {
            (new Errors())->show404();
        }
    }

    /**
     * True if application run from index
     * @return bool
     */
    public function isLegal() {
        return $this->legal;
    }

    /**
     *
     */
    public function __destruct() {
        // TODO: Implement __destruct() method.
    }
}