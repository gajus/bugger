<?php
namespace Gajus\Bugger;

/**
 * 
 * 
 * @link https://github.com/gajus/bump for the canonical source repository
 * @license https://github.com/gajus/bump/blob/master/LICENSE BSD 3-Clause
 */
class Bugger {
	

	/**
	 * Terminates script, discards the output buffer and dumps information about the variable.
	 * 
	 * @param mixed $expression The variable you want to dump.
	 * @param mixed ...
	 * @return null
	 */
	static public function dump () {
		while (ob_get_level()) {
			ob_end_clean();
		}

		$backtrace = debug_backtrace();

		$arguments = func_get_args();

		ob_start();
		call_user_func('var_dump', $arguments);
		$response = ob_get_clean();

		#$var_dump = bump_return_var_dump();

		#$response .= bump_format_debug_backtrace($backtrace);

		#$GLOBALS['gajus']['bump'] = ['backtrace' => debug_backtrace(), 'var_dump' => $var_dump];

		exit;
	}
}