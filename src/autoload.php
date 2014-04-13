<?php
if (isset($GLOBALS['gajus']['bugger'])) {
	return;
}

$GLOBALS['gajus']['bugger'] = [];

register_shutdown_function(function () {
	/*if (!isset($GLOBALS['gajus']['bump']) && !isset($GLOBALS['gajus']['mump'])) {
		return;
	}

	if (php_sapi_name() !== 'cli') {
		while (ob_get_level()) {
			ob_end_clean();
		}

		if (!headers_sent()) {
			header('Content-Type: text/html; charset="UTF-8"', true);
		}
	} else {
		throw new \Gajus\Bugger\Exception\LogicException('Bugger does not work in CLI environment.');
	}

	$response = $GLOBALS['gajus']['bump'];

	require __DIR__ . '/template.php';*/
});

require __DIR__ . '/Bugger.php';