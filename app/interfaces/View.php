<?php
/**
 * Created by PhpStorm.
 * User: PretorDH (Serhii Usik)
 * Date: 06.01.2019
 * Time: 11:56
 */

namespace app\interfaces;


/**
 * Interface View
 * @package app\interfaces
 */
interface View {
    /**
     * Render view content
     *
     * @return string
     */
    public function render(): string;
}