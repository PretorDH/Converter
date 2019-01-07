<?php
/**
 * Copyright (c) 2019. DeParadox LLC
 */

/**
 * Created by PhpStorm.
 * User: PretorDH (Serhii Usik)
 * Date: 06.01.2019
 * Time: 17:07
 */

namespace app\interfaces;


/**
 * Interface Controller
 * @package app\interfaces
 */
interface Controller {
    /**
     * HTTP_ACCEPT destructure pattern
     */
    const ACCEPT_PATTERN = '/(?\'type\'[\*\w]+)\/(?\'mime\'(?<=\/)[\*\w+-]+)(;q=(?\'q\'(?<=;q=)[\d\.]+))?/i';
}