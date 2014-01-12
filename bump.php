<?php
ob_start(function ($buffer) {
	if (isset($GLOBALS['bump'])) {
		return $GLOBALS['bump'];
	} else {
		return $buffer;
	}
});

/**
 * Used to dump information about variables and access the backtrace log.
 * This function is intentionally made available to the global scope.
 * 
 * @author Gajus Kuizinas <g.kuizinas@anuary.com>
 * @version 1.0.5 (2012 11 09)
 */
function bump () {
	if (ob_get_level()) {
		ob_clean();
	}
    
	header('Content-Type: text/plain; charset="UTF-8"', true);
	
	// Unless something went really wrong, $trace[0] will always reference call to ay().
	$trace = debug_backtrace()[0];
	
	ob_start();
	echo 'ay() called in ' . $trace['file'] . ' (' . $trace['line'] . ').' . PHP_EOL . PHP_EOL;
	
	call_user_func_array('var_dump', func_get_args());
	
	echo PHP_EOL . 'Backtrace:' . PHP_EOL . PHP_EOL;
	
	debug_print_backtrace();
	$response = ob_get_clean();
	
	$response = preg_replace('/(?!\n)[\p{Cc}]/', '', $response);
	
	$response = preg_replace_callback('/int\(([0-9]{10})\)/', function ($e) {
		return $e[0] . ' <== ' . date('Y-m-d H:i:s', $e[1]);
	}, $response);
	
	$GLOBALS['bump'] = $response;
	
	exit;
}