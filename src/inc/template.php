<!DOCTYPE html>
<html>
<head>
	<style>
	<?php
	if (false) {
		echo file_get_contents(__DIR__ . '/static/js/syntaxhighlighter/styles/shCore.css');
		echo file_get_contents(__DIR__ . '/static/js/syntaxhighlighter/styles/shCoreDefault.css');
	} else {
		echo file_get_contents(__DIR__ . '/static/css/shCoreShDefault.css');
	}
	?>
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
	<?php foreach ($stack as $trace):?>
	<ol class="stack">
		<?php foreach ($trace as $t):?>
		<li>
			<?php if (isset($t['file'])):

			$file = file($t['file']);
			$file = array_slice($file, max($t['line'] - 3, 0), 5);
			$file = array_map('rtrim', $file);
			$file = array_map(function ($e) { return $e ? $e : '	'; }, $file);
			?>
			<div class="location">
				<span class="file">../<?=explode('/', mb_substr($t['file'], -80), 2)[1]?></span>:<span class="line"><?=$t['line']?></span>
			</div>
			<pre class="brush: php; highlight: <?=$t['line']?>; first-line: <?=max($t['line'] - 2, 1)?>;"><?=htmlspecialchars(implode($file, "\n"))?></pre>
			<?php endif;?>
			
			<pre class="brush: php;"><?php
			ob_start();
			var_dump($t['args']);
			echo  htmlspecialchars(ob_get_clean());
			?></pre>
		</li>
		<?php endforeach;?>
	</ol>
	<?php endforeach;?>

	<script>
	SyntaxHighlighter.defaults.toolbar = false;
	SyntaxHighlighter.all();
	</script>
</body>
</html>