<?php
/**
 * Copyright (c) 2019. DeParadox LLC
 */

/**
 * Created by PhpStorm.
 * User: PretorDH (Serhii Usik)
 * Date: 07.01.2019
 * Time: 8:38
 */

namespace app\common;


use app\config\App;
use app\interfaces\View as ViewInterface;

/**
 * Class View
 * @package common
 */
class View implements ViewInterface {
    /**
     * Global data set by middleware
     *
     * @var array|null
     */
    public static $middlewareData;
    /**
     * Counter of instances
     * @var int
     */
    private static $instancesCount = 0;
    /**
     * Data set by controller
     *
     * @var array|null
     */
    protected $controllerData = [];

    /**
     * Template file name
     *
     * @var string
     */
    protected $template;

    /**
     * Generated content
     *
     * @var string
     */
    private $content = '';


    /**
     * View constructor.
     * @param string $template Template file name
     * @param array $data
     */
    public function __construct($template = null, $data = []) {
        self::$instancesCount++;
        $this->template = $template;

        $this->controllerData = array_merge($this->controllerData, $data);
    }

    /**
     * Set middleware data field as new value
     *
     * @param $name string Field name
     * @param $data mixed New data value
     * @return mixed Data value
     */
    public static function __callStatic($name, $data) {
        if ($data === null) {
            return self::$middlewareData[$name] ?? null;
        }

        if (\is_array($data)) {
            foreach ($data as $key => $value) {
                self::$middlewareData[$key] = $value;
            }
        } else {
            self::$middlewareData[$name] = $data;
        }

        return $data;
    }

    /**
     * Return field from controller data
     *
     * @param $name
     * @return null
     */
    public function __get($name) {
        return $this->controllerData[$name] ?? null;
    }

    /**
     * Set controller data field as new value
     *
     * @param $name string Field name
     * @param $data mixed New data value
     * @return self
     */
    public function __set($name, $data = NULL) {
        if (\is_array($data) || $data instanceof \Traversable) {
            foreach ($data as $key => $value) {
                $this->controllerData[$key] = $value;
            }
        } else {
            $this->controllerData[$name] = $data;
        }

        return $this;
    }

    /**
     * Return true if field exists in controller or middleware data.
     * Else return false.
     * @param $name
     * @return bool
     */
    public function __isset($name) {
        return isset($this->controllerData[$name]) ?: isset(self::$middlewareData[$name]) ?: false;
    }

    /**
     * Magic method.
     * Generate content if necessary and return it
     *
     * @return string Return content of view
     */
    public function __toString(): string {

        return $this->content ?: $this->render();
    }

    /**
     * Content renderer
     *
     * @return string
     */
    public function render(): string {
        extract($this->controllerData, EXTR_SKIP);

        if (self::$middlewareData) {
            extract(self::$middlewareData, EXTR_SKIP | EXTR_REFS);
        }

        ob_start();

        try {
            include App::VIEWS_DIR . $this->template;
        } catch (\Exception $e) {
            ob_end_clean();
        }

        $this->content = ob_get_clean();

        return $this->content;
    }

    /**
     * Auto decrease instances counter
     */
    public function __destruct() {
        self::$instancesCount--;
    }
}