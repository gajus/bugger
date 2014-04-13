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

		ob_start();
		?>
		<!DOCTYPE html>
		<html>
		<head>
			<style>
			html,
			body {
				font-family: monospace; font-size: 13px; background: #D4D4D4; margin: 0; padding: 0 0 0 50px;
			}

			pre {
				word-wrap: break-word; white-space: pre-wrap;
			}

			#backtrace {
				display: block; margin: 0; padding: 0; background: #fff;
			}

			#backtrace li {
				display: block; list-style: none; margin: 0; padding: 10px; overflow: hidden; border-bottom: 1px solid #D4D4D4;
			}

			/*#backtrace li:first-child { background: #4288CE; color: #fff; }

			#dump {
				margin: 40px; display: block;
			}*/

			.location {
				padding: 20px; background: #666699; color: #fff;
			}

			.code,
			.args { background: #D4D4D4; color: #000; padding: 20px; }

			.code { background: #F8EEC7; cursor: pointer; }

			.args.min {
				max-height: 200px; overflow: hidden;
			}
			</style>

			<script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>

			<script>
			$(function () {
				$('.code').on('click', function () {
					var argsContainer = $(this).parents('li').find('.args');

					argsContainer.toggleClass('min');
				});
			});
			</script>
		</head>
		<body>
			<div id="aux">
				<ol id="backtrace">
					<?php
					foreach ($response['backtrace'] as $trace) {
						?>
						<li>
						<?php if (isset($trace['file'])):?>
							<div class="location">
								<span class="file">../<?=explode('/', mb_substr($trace['file'], -80), 2)[1]?></span>
								:<span class="line"><?=$trace['line']?></span>
							</div>
							<div class="code"><?=htmlspecialchars(trim(file($trace['file'])[$trace['line'] - 1]))?></div>
							<pre class="args min"><?=htmlspecialchars(bump_return_var_dump($trace['args']))?></pre>
						<?php endif;?>
						</li>
						<?php
				        #echo '<li>' . $trace['file'] . '(' . $trace['line'] . '): ' . (isset($trace['class']) ? $trace['class'] . '->' : '') . $trace['function'] . '(' . implode(', ', $trace['args']) . ') </li>'; 
					}
					?>
				</ol>
			</div>
		</body>
		</html>
		<?php
		echo ob_get_clean();
		
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