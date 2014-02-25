<?php
// In case bump has been loaded using http://uk1.php.net/manual/en/ini.core.php#ini.auto-prepend-file.
if (!function_exists('bump')) {
	ob_start();

	register_shutdown_function(function () {
		if (!isset($GLOBALS['bump'])) {
			return;
		}

		if (php_sapi_name() !== 'cli') {
			while (ob_get_level()) {
				ob_end_clean();
			}

			header('Content-Type: text/plain; charset="UTF-8"', true);
		}

		echo $GLOBALS['bump'];
	});

	/**
	 * Used to dump information about variables and the backtrace log.
	 * This function is intentionally made available to the global scope.
	 */
	function bump () {
		while (ob_get_level()) {
			ob_end_clean();
		}
		
		ob_start();
		call_user_func_array('var_dump', func_get_args());
		
		echo PHP_EOL . 'Backtrace:' . PHP_EOL . PHP_EOL;
		
		debug_print_backtrace();

		$response = ob_get_clean();
		
		// Convert control characters to hex representation.
		// Refer to http://stackoverflow.com/a/8171868/368691
		// @todo This implementation will not be able to represent pack('S', 65535).
		$response = preg_replace_callback('/[\x00-\x08\x0B\x0C\x0E-\x1F\x80-\x9F]/u', function ($e) {
			return '\\' . bin2hex($e[0]);
		}, $response);
		
		// Match everything that looks like a timestamp and convert it to a human readable date-time format.
		$response = preg_replace_callback('/int\(([0-9]{10})\)/', function ($e) {
			return $e[0] . ' <== ' . date('Y-m-d H:i:s', $e[1]);
		}, $response);
		
		$GLOBALS['bump'] = $response;
		
		exit;
	}
}