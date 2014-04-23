<?php
namespace Gajus\Bugger;

/**
 * 
 * @link https://github.com/gajus/bump for the canonical source repository
 * @license https://github.com/gajus/bump/blob/master/LICENSE BSD 3-Clause
 */
class Bugger {
    static private
        $tracestack = [],
        $ticks = [];

    /**
     * Terminates the script, discards the output buffer, dumps information about the expression including backtrace up to the `trace` call.
     * 
     * @param mixed $expression The variable you want to dump.
     * @return null
     * @codeCoverageIgnore
     */
    static public function trace ($expression = null) {
        while (ob_get_level()) {
            ob_end_clean();
        }

        static::$tracestack = [static::getBacktrace()];

        exit;
    }

    /**
     * Stacks information about the expression and dumps the stack at the end of the script execution.
     *
     * @param mixed $expression The variable you want to dump.
     * @return null
     * @codeCoverageIgnore
     */
    static public function stack ($expression = null) {
        while (ob_get_level()) {
            ob_end_clean();
        }

        static::$tracestack[] = static::getBacktrace();

        ob_start();
    }

    /**
     * Tracks the number of times tick function itself has been called and returns true
     * when the desired number within the namespace is reached.
     *
     * @param int $true_after Number of the itteration after which response is true.
     * @param string $namespace Itteration namespace.
     * @return boolean
     */
    static public function tick ($true_after, $namespace = 'default') {
        if (!isset(static::$ticks[$namespace])) {
            static::$ticks[$namespace] = 0;
        }

        return ++static::$ticks[$namespace] >= $true_after;
    }

    /**
     * @return array
     * @codeCoverageIgnore
     */
    static private function getBacktrace () {
        $backtrace = debug_backtrace();

        foreach ($backtrace as $i => $b) {
            if (isset($backtrace[$i]['function'], $backtrace[$i + 1]['function']) && in_array($backtrace[$i]['function'], ['stack', 'trace', 'tick']) && $backtrace[$i + 1]['function'] === 'forward_static_call_array') {
                unset($backtrace[$i - 1], $backtrace[$i], $backtrace[$i + 1]);
            } else if (isset($backtrace[$i])) {
                ob_start();
                var_dump($backtrace[$i]['args']);
                $backtrace[$i]['args_dump'] = htmlspecialchars(ob_get_clean());

                $backtrace[$i]['args_dump'] = static::sanitise($backtrace[$i]['args_dump']);
                $backtrace[$i]['args_dump'] = static::translateTimestamp($backtrace[$i]['args_dump']);
            }
        }

        return array_values($backtrace);
    }

    /**
     * Convert control characters to hex representation.
     * Refer to http://stackoverflow.com/a/8171868/368691
     * 
     * @todo This implementation will not be able to represent pack('S', 65535).
     * @param string $output
     * @return string
     */
    static private function sanitise ($output) {
        $regex_encoding = mb_regex_encoding();

        mb_regex_encoding('UTF-8');

        $output = \mb_ereg_replace_callback('[\x00-\x08\x0B\x0C\x0E-\x1F\x80-\x9F]', function ($e) {
            return '\\' . bin2hex($e[0]);
        }, $output);

        if ($output === false) {
            throw new Exception\ErrorException('PCRE error ocurred while stripping out non-printable characters.');
            
            # var_dump( array_flip(get_defined_constants(true)['pcre'])[preg_last_error()] );
        }

        mb_regex_encoding($regex_encoding);

        return $output;
    }

    /**
     * Match everything that looks like a timestamp and convert it to a human readable date-time format.
     * 
     * @param string $output
     * @return string
     */
    static private function translateTimestamp ($output) {
        $regex_encoding = mb_regex_encoding();

        $output = \mb_ereg_replace_callback('int\(([0-9]{10})\)', function ($e) {
            if ($e[1] < mktime(0,0,0,1,1,2000) || $e[1] > mktime(0,0,0,1,1,2020)) {
                return $e[0];
            }

            return $e[0] . ' <== ' . date('Y-m-d H:i:s', $e[1]);
        }, $output);

        if ($output === false) {
            throw new Exception\ErrorException('PCRE error ocurred while attempting to replace timestamp values with human-friedly format.');
            
            # var_dump( array_flip(get_defined_constants(true)['pcre'])[preg_last_error()] );
        }

        mb_regex_encoding($regex_encoding);

        return $output;
    }

    /**
     * @return array
     */
    static public function getTracestack () {
        return static::$tracestack;
    }

    static public function resetTick () {
        static::$ticks = [];
    }
}