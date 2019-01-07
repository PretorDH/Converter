<?php
/**
 * Copyright (c) 2019. DeParadox LLC
 */

/**
 * Created by PhpStorm.
 * User: PretorDH (Serhii Usik)
 * Date: 06.01.2019
 * Time: 22:16
 */

namespace app\controllers;

use app\common\View;

/**
 * Class Errors
 * @package app\controllers
 */
class Errors extends \app\common\Controller {
    /**
     * Page 404 action
     */
    public function show404() {
        $this->response(new View('errors/404.php'),404);
    }
}