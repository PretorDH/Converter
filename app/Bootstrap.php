<?php
/**
 * Copyright (c) 2019. DeParadox LLC
 */

/**
 * Created by PhpStorm.
 * User: PretorDH (Serhii Usik)
 * Date: 06.01.2019
 * Time: 17:22
 */

namespace app;


use Bramus\Router\Router;

/**
 * Class Bootstrap
 * @package app
 */
class Bootstrap {
    /**
     * Instance of application router
     * @var Router
     */
    public $router;

    /**
     * Bootstrap constructor.
     */
    public function __construct() {
        session_start();

        $this->router = new Router();
        $this->routing();
    }

    /**
     * Hook routes
     */
    protected function routing() {
        $this->router->setNamespace('\app\controllers');

        $this->router->get('/', 'guest\Currency@showConverter');
        $this->router->post('/convert', 'guest\Currency@doConvert');

        $this->router->set404('Errors@show404');
    }

    /**
     * Run routing
     */
    public function run() {
        $this->router->run();
    }
}