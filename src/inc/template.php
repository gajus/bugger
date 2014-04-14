<!DOCTYPE html>
<html>
<head>
	<style>
	<?=file_get_contents(__DIR__ . '/static/js/syntaxhighlighter/styles/shCore.css')?>
	<?=file_get_contents(__DIR__ . '/static/js/syntaxhighlighter/styles/shCoreDefault.css')?>
	<?=file_get_contents(__DIR__ . '/static/css/bugger.css')?>
	</style>

	<script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>

	<script>
	<?=file_get_contents(__DIR__ . '/static/js/bugger.js')?>

	<?=file_get_contents(__DIR__ . '/static/js/syntaxhighlighter/scripts/shCore.js')?>
	<?=file_get_contents(__DIR__ . '/static/js/syntaxhighlighter/scripts/shBrushPhp.js')?>
	</script>
</head>
<body>
	<ol id="backtrace">
		<?php foreach ($response['backtrace'] as $trace):?>
		<li>
			<?php if (isset($trace['file'])):

			$file = file($trace['file']);
			$file = array_slice($file, max($trace['line'] - 3, 0), 5);
			$file = array_map('rtrim', $file);
			$file = array_map(function ($e) { return $e ? $e : '	'; }, $file);
			?>
			<div class="location">
				<span class="file">../<?=explode('/', mb_substr($trace['file'], -80), 2)[1]?></span>:<span class="line"><?=$trace['line']?></span>
			</div>
			<pre class="brush: php; highlight: <?=$trace['line']?>; first-line: <?=max($trace['line'] - 2, 1)?>;"><?=htmlspecialchars(implode($file, "\n"))?></pre>
			<?php endif;?>
			
			<pre class="brush: php;"><?php
			ob_start();
			var_dump($trace['args']);
			echo  htmlspecialchars(ob_get_clean());
			?></pre>
		</li>
		<?php endforeach;?>
	</ol>

	<script>
	SyntaxHighlighter.defaults.toolbar = false;
	SyntaxHighlighter.all();
	</script>
</body>
</html>