<?php
if (!isset($GLOBALS['gajus']['bump'])) {
	$GLOBALS['gajus']['bump'] = true;

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
}