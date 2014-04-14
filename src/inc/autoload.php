<?php
if (isset($GLOBALS['gajus']['bugger'])) {
	return;
} else {
	function trace () {
		return forward_static_call_array('Gajus\Bugger\Bugger::trace', func_get_args());
	}

	function stack () {
		return forward_static_call_array('Gajus\Bugger\Bugger::stack', func_get_args());
	}

	function tick () {
		return forward_static_call_array('Gajus\Bugger\Bugger::tick', func_get_args());
	}
}

$GLOBALS['gajus']['bugger'] = [];

register_shutdown_function(function () {
	$stack = \Gajus\Bugger\Bugger::getStack();

	if ($stack) {
		if (php_sapi_name() === 'cli') {
			throw new \Gajus\Bugger\Exception\LogicException('Bugger does not work in CLI environment.');
		} else {
			while (ob_get_level()) {
				ob_end_clean();
			}

			if (!headers_sent()) {
				header('Content-Type: text/html; charset="UTF-8"', true);
			}
		}

		require __DIR__ . '/template.php';
	} else {
		return;
	}
});

require __DIR__ . '/../Bugger.php';