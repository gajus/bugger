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

	<script>
	<?=file_get_contents(__DIR__ . '/static/js/jquery-2.1.0.min.js')?>
	<?=file_get_contents(__DIR__ . '/static/js/bugger.js')?>

	<?=file_get_contents(__DIR__ . '/static/js/syntaxhighlighter/scripts/shCore.js')?>
	<?=file_get_contents(__DIR__ . '/static/js/syntaxhighlighter/scripts/shBrushPhp.js')?>
	</script>
</head>
<?php
$display_number_of_lines = 10;
?>
<body>
	<div id="bugger">
		<?php foreach ($stack as $trace):?>
		<ol class="stack">
			<?php foreach ([array_shift($trace)] as $t):?>
			<li>
				<?php
				if (isset($t['file'])):

				$file = file($t['file']);
				$file = array_map('rtrim', $file);

				$number_of_line_start = max($t['line'] - $display_number_of_lines / 2, 0);
				#$number_of_line_end = $display_number_of_lines - ($t['line'] - $number_of_line_start);

				$file = array_slice($file, $number_of_line_start, $display_number_of_lines);
				$file = array_map(function ($e) { return $e ? $e : '	'; }, $file);
				?>
				<div class="location">
					<span class="file">../<?=explode('/', mb_substr($t['file'], -80), 2)[1]?></span>:<span class="line"><?=$t['line']?></span>
				</div>
				<pre class="brush: php; first-line: <?=$number_of_line_start + 1?>; highlight: <?=$t['line']?>;"><?=htmlspecialchars(implode($file, "\n"))?></pre>
				<?php endif;?>
				
				<pre class="brush: php;"><?=$t['args_dump']?></pre>
			</li>
			<?php endforeach;?>
		</ol>
		<?php endforeach;?>
	</div>

	<script>
	SyntaxHighlighter.defaults.toolbar = false;
	SyntaxHighlighter.all();
	</script>
</body>
</html>