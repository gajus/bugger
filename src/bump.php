<?php
if (!function_exists('bump')) {
	ob_start();

	register_shutdown_function(function () {
		if (!isset($GLOBALS['gajus']['bump']) && !isset($GLOBALS['gajus']['mump'])) {
			return;
		}

		if (php_sapi_name() !== 'cli') {
			while (ob_get_level()) {
				ob_end_clean();
			}

			if (!headers_sent()) {
				header('Content-Type: text/html; charset="UTF-8"', true);
			}
		}

		#if (isset($GLOBALS['gajus']['bump'])) {
			$response = $GLOBALS['gajus']['bump'];
		#} else {
		#	$response = implode(PHP_EOL, $GLOBALS['gajus']['mump']);
		#}

		require __DIR__ . '/template.php';		
	});

	/**
	 * Discard output buffer and dump information about the expressions.
	 */
	function bump () {
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

	/*function mump () {
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

	function tick ($catch_at) {
		if (!isset($GLOBALS['gajus']['tick'])) {
			$GLOBALS['gajus']['tick'] = 0;
		}

		return ++$GLOBALS['gajus']['tick'] === $catch_at;
	}*/

	function bump_sanitise_output ($output) {
		$regex_encoding = mb_regex_encoding();

		mb_regex_encoding('UTF-8');

		// Convert control characters to hex representation.
		// Refer to http://stackoverflow.com/a/8171868/368691
		// @todo This implementation will not be able to represent pack('S', 65535).
		$output = \mb_ereg_replace_callback('[\x00-\x08\x0B\x0C\x0E-\x1F\x80-\x9F]', function ($e) {
		    return '\\' . bin2hex($e[0]);
		}, $output);

		if ($output === false) {
		    throw new \ErrorException('PCRE error ocurred while stripping out non-printable characters.');
		    
		    var_dump( array_flip(get_defined_constants(true)['pcre'])[preg_last_error()] );

		    exit;
		}

		// Match everything that looks like a timestamp and convert it to a human readable date-time format.
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

	function bump_return_var_dump (array $args) {
		ob_start();
		call_user_func_array('var_dump', $args);
		return ob_get_clean();
	}
}