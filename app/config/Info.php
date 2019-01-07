<?php
/**
 * Copyright (c) 2018. DeParadox LLC
 */

/**
 * Created by PhpStorm.
 * User: PretorDH (Serhii Usik)
 * Date: 07.07.2018
 * Time: 17:07
 */

namespace app\config;


/**
 * Interface Info
 * @package app\config
 */
interface Info {
    /**
     *  boolean Activate Debug
     */
    const DEBUG = true;
    /**
     *  boolean Save log into file or drop
     */
    const SAVE_LOG = false;
    /**
     *  boolean Add overall memory usage into log
     */
    const MEMORY_LOG = true;
    /**
     *  boolean Add modules autoload into log
     */
    const INCLUDE_LOG = true;
    /**
     * boolean Add relative time labels into log
     */
    const PROFILE_LOG = true;
    /**
     *  int File size limit. When the limit is exceeded file
     */
    const LIMIT_LOG = 409600;
    /**
     *  string Log file name
     */
    const LOG_FILE = __DIR__ . '/../admin.log';
    /**
     *  string CSS style for frontend logger
     */
    const LOG_STYLE_FILE = __DIR__.'/css/info.css';
}