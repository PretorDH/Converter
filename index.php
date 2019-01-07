<?php
/**
 * Copyright (c) 2019. DeParadox LLC
 */

/**
 * Created by PhpStorm.
 * User: PretorDH (Serhii Usik)
 * Date: 06.01.2019
 * Time: 12:16
 */

new class {
    public function __construct() {
        require 'vendor/autoload.php';

        define('APP_LEGAL', true);

        new app\App( APP_LEGAL );
    }
};

