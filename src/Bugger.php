<?php
namespace Gajus\Bugger;

/**
 * 
 * 
 * @link https://github.com/gajus/bump for the canonical source repository
 * @license https://github.com/gajus/bump/blob/master/LICENSE BSD 3-Clause
 */
class Bugger {
	static private
		$ticks = [];

	/**
	 * Discard output buffer and dump information about the expressions.
	 */
	static public function bump () {
		while (ob_get_level()) {
			ob_end_clean();
		}

		$backtrace = debug_backtrace();

		#die(var_dump( count($backtrace) ));

		$var_dump = bump_return_var_dump(func_get_args());

		#$response .= bump_format_debug_backtrace($backtrace);

		$GLOBALS['gajus']['bump'] = ['backtrace' => debug_backtrace(), 'var_dump' => $var_dump];

		exit;
	}

	/**
	 *
	 */
	static public function mump () {
		#set_error_handler(function () { exit; });
		#set_exception_handler(function () { exit; });

		while (ob_get_level()) {
			ob_end_clean();
		}
		
		ob_start();

		call_user_func_array('var_dump', func_get_args());
		
		echo PHP_EOL . 'Backtrace:' . PHP_EOL . PHP_EOL;
		
		debug_print_backtrace();

		$GLOBALS['gajus']['mump'][] = ob_get_clean();

		ob_start();
	}

	/**
	 * Tick function is used to debug loop events. You can use it to stop loop at a specific itteration number.
	 *
	 * @param int $true_at Number of the itteration after which response is true.
	 * @param string $namespace Itteration namespace.
	 * @return boolean
	 */
	static public function tick ($true_at, $namespace = 'global') {
		if (!isset(static::$ticks[$namespace])) {
			static::$ticks[$namespace] = 0;
		}

		return ++static::$ticks[$namespace] === $true_at;
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
		    throw new \ErrorException('PCRE error ocurred while stripping out non-printable characters.');
		    
		    var_dump( array_flip(get_defined_constants(true)['pcre'])[preg_last_error()] );

		    exit;
		}		

		return $output;
	}

	/**
	 * Match everything that looks like a timestamp and convert it to a human readable date-time format.
	 * 
	 * @param string $output
	 * @return string
	 */
	static private function readableTimestamp ($output) {
		$output = \mb_ereg_replace_callback('int\(([0-9]{10})\)', function ($e) {
		    return $e[0] . ' <== ' . date('Y-m-d H:i:s', $e[1]);
		}, $output);

		if ($output === false) {
		    throw new \ErrorException('PCRE error ocurred while attempting to replace timestamp values with human-friedly format.');
		    
		    var_dump( array_flip(get_defined_constants(true)['pcre'])[preg_last_error()] );

		    exit;
		}

		mb_regex_encoding($regex_encoding);

		return $output;
	}
}