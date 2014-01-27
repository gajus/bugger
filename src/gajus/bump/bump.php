<?php
// In case bump has been loaded using http://uk1.php.net/manual/en/ini.core.php#ini.auto-prepend-file.
if (!function_exists('bump')) {
	ob_start();

	register_shutdown_function(function () {
		if (!isset($GLOBALS['bump'])) {
			return;
		}

		if (php_sapi_name() !== 'cli') {
			ob_end_clean();

			header('Content-Type: text/plain; charset="UTF-8"', true);
		}

		echo $GLOBALS['bump'];
	});

	/**
	 * Used to dump information about variables and access the backtrace log.
	 * This function is intentionally made available to the global scope.
	 */
	function bump () {
		if (ob_get_level()) {
			ob_end_clean();
		}
		
		ob_start();
		call_user_func_array('var_dump', func_get_args());
		
		echo PHP_EOL . 'Backtrace:' . PHP_EOL . PHP_EOL;
		
		debug_print_backtrace();

		$response = ob_get_clean();
		
		// This ensures that only readable characters are outputed.
		$safe_response = preg_replace('/(?!\n)[\p{Cc}]/', '', $response);

		if ($response !== $safe_response) {
			$safe_response = 'The output has been altered to exclude non-printable characters.' . PHP_EOL . $safe_response;
		}
		
		// Math everything that looks like a timestamp and convert it to a human readable date-time format.
		$response = preg_replace_callback('/int\(([0-9]{10})\)/', function ($e) {
			return $e[0] . ' <== ' . date('Y-m-d H:i:s', $e[1]);
		}, $response);
		
		$GLOBALS['bump'] = $response;
		
		exit;
	}
}