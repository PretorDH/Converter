<?php
/**
 * @copyright Copyright (c) 2015-2019. DeParadox LLC
 * @mail deparadox.js@gmail.com
 */

namespace app\common;

use app\config\Info as Config;

/**
 * <h1>DeParadox proprietary logger class</h1>
 * <h2>Provide:</h2>
 * <ul>
 *     <li>frontend in page logging</li>
 *     <li>logging into file</li>
 *     <li>"on fly" logging interface client panel</li>
 *     <li>"on fly" in browser log file viewer</li>
 *     <li>client side log clearing method</li>
 * </ul>
 * <h2>Required:</h2>
 * <h3>CLass</h3>
 * <data value="config\Info">config\Info</data>
 * <h3>Constants in Config::</h3>
 * <ul>
 *     <li>DEBUG          - enable front end request summary log</li>
 *     <li>SAVE_LOG       - enable save into file</li>
 *     <li>MEMORY_LOG     - enable memory usage logging</li>
 *     <li>INCLUDE_LOG    - enable logging modules loading</li>
 *     <li>LIMIT_LOG      - File size limit. When the limit is exceeded file be cleared</li>
 *     <li>LOG_FILE       - log file uri</li>
 *     <li>LOG_STYLE_FILE - CSS style for frontend logger</li>
 * </ul>
 * @package DeParadox\core
 * @property
 */
class Info implements Config {
    static private $debug_info = ' ';
    static private $instance;
    static private $last = null;

    private $requestUri;
    private $requestTime;
    private $remoteAddress;
    private $remoteCommand;

    function __construct() {
        self::$instance = $this;

        $this->remoteCommand = $_POST['cmd'] ?? '';
        $this->requestUri = $_SERVER['REQUEST_URI'] ?? ' Request Uri not detected';
        $this->remoteAddress = $_SERVER['REMOTE_ADDR'] ?? ' Remote Address not detected';
        $this->requestTime = $_SERVER['REQUEST_TIME_FLOAT'] ?? ' Request Time not detected';

        switch (true) {
            /** @noinspection PhpMissingBreakStatementInspection */
            case      'Clear' === $this->remoteCommand:
                self::clear();
            case '/admin.log' === $this->requestUri   :
            case       'Info' === $this->remoteCommand:
                exit(self::getInfo());
            default:
        }

        self::setInfo("| Application '$this->requestUri'");
        self::setInfo("| Started " . $this->getTimeStamp());
        self::setInfo("| Caller IP: '$this->remoteAddress' =");

        if (self::MEMORY_LOG) {
            self::setInfo("| Memory base: ". memory_get_usage());
            self::setInfo("| Memory real usage : ". memory_get_usage(true) );
        }

        self::setInfo(str_repeat("–", 55));
    }

    public static function clear() {
        file_put_contents(self::LOG_FILE, "<p>Cleared</p>");

        return "<p>Cleared</p>";
    }

    static function getInfo() {
        if (!file_exists(self::LOG_FILE) || filesize(self::LOG_FILE) > self::LIMIT_LOG) {
            self::clear();
        }

        return file_get_contents(self::LOG_FILE);
    }

    /**
     * Store value/variable into log destinations
     *
     * @param $text
     */
    protected static function setInfo($text) {
        self::$last = $text;

        switch (true) {
            case     is_bool($text):
                self::$last = $text ? 'true' : 'false';
                break;
            case     null === $text:
                self::$last = 'null';
                break;
            case    is_array($text):
            case   is_object($text):
                self::$last = print_r($text, true);
                break;
            default:
        }

        if (self::PROFILE_LOG) {
        	self::$last = self::getTimeRelative() . 'ms > '. self::$last;
        }

        if (self::DEBUG) {
            self::$debug_info .= PHP_EOL . "<pre>" . htmlspecialchars(self::$last) . "</pre>";
        }

        if (self::SAVE_LOG) {
            if (!file_exists(self::LOG_FILE)) {
                self::clear();
            }
            file_put_contents(self::LOG_FILE, PHP_EOL . self::$last, FILE_APPEND);
        }
    }

	/**
	 * Generate text with absolute & relative time
	 *
	 * @return string
	 */
	private function getTimeStamp() {
		$now = date_create('now')->format("Y/m/d H:i:s");
		$micro = self::getTimeRelative();

		return " $now (at $micro ms) ";
    }


	/**
	 * Return relative time
	 *
	 * @return string
	 */
	public static function getTimeRelative() {
		return number_format(( microtime(true) - self::$instance->requestTime ) * 1000, 0);
    }

    public static function getLast() {
        return self::$last;
    }

    public static function keys($var) {
        if (is_object($var)) {
            self::dump(\ReflectionObject::export($var, true), 'Object fields');
        } elseif (is_array($var)) {
            self::dump(array_keys($var), 'Array keys');
        } else {
            self::setInfo('Not traversable.');
        }
    }

    public static function dump($var, $pre = 'Dump') {
        self::setInfo("----- $pre -----");
        self::setInfo($var);

        return $var;
    }

    public function getSource($instance) {
        if (!is_callable($instance)) {
            return 'Has no code!';
        }
        // Separate instance and method from string
        if (is_string($instance)) {
            $instance = count($instance = explode('::', $instance)) == 1 ? $instance[0] : $instance;
        }
        // Create reflections for instances
	    try {
	        if (is_array($instance)) {
	            $func = new \ReflectionMethod($instance[0], $instance[1]);
	        } else {
	            $func = new \ReflectionFunction($instance);
	        }
	    } catch ( \ReflectionException $exception ) {
			header('HTTP/1.0 500 Reflection error...');
		}
        // Get position of function in source
        $filename = $func->getFileName();
        $start_line = $func->getStartLine();
        $end_line = $func->getEndLine();
        $length = $end_line - --$start_line;
        // Get code from source
        $source = file($filename);
        $body = implode("", array_slice($source, $start_line, $length));

        return self::log($body);
    }

    public static function log( $text = null ) {
        self::setInfo($text);

        return $text;
    }

    private function finaliseDebug () {
        self::setInfo(str_repeat("–", 55));
        if (self::MEMORY_LOG) {
            self::setInfo("| Peak memory: " . ( memory_get_peak_usage() ));
        }
        self::setInfo("| Application end " . $this->getTimeStamp());
    }

    function __destruct() {
        $this->finaliseDebug();
    }

    /**
     * Return debug Side widget
     *
     * @return string
     */
    public static function getDebug() {
        if (\defined('UNIT_TESTING') ) {
            return '';
        }

        self::$instance->finaliseDebug();
        if ( $_SERVER['HTTP_ACCEPT'] && false!==strpos($_SERVER['HTTP_ACCEPT'],'text/html')) {
            return
                "<style>". file_get_contents(self::LOG_STYLE_FILE) ."</style>" . PHP_EOL .
                "<div id='debug'>" . PHP_EOL .
                     self::$debug_info . PHP_EOL .
                "</div>" . PHP_EOL;
        }

        return self::$debug_info;
    }
}

new Info;