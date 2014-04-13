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