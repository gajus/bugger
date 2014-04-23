<!DOCTYPE html>
<html>
<head>
	<style>
	<?=file_get_contents(__DIR__ . '/static/css/bugger.css')?>
	<?=file_get_contents(__DIR__ . '/static/css/syntaxhighlighter/shThemeDefault.css')?>
	<?=file_get_contents(__DIR__ . '/static/css/syntaxhighlighter/shCore.css')?>
	</style>
	
	<script>
	<?=file_get_contents(__DIR__ . '/static/js/jquery-2.1.0.min.js')?>
	<?=file_get_contents(__DIR__ . '/static/js/syntaxhighlighter/scripts/shCore.js')?>
	<?=file_get_contents(__DIR__ . '/static/js/syntaxhighlighter/scripts/shBrushPhp.js')?>
	</script>
</head>
<body>
	<div id="bugger" style="width: <?=count($tracestack) * 610?>px">
		<?php foreach ($tracestack as $stack):?>
		<div class="trace">
			<?php foreach ($stack as $trace):?>
			<div class="card">
				<div class="header">
		            <?=$trace['file']?>
		        </div>
		        <div class="dump">
		            <pre class="brush: php; gutter: false;"><?=$trace['args_dump']?></pre>
		        </div>
		        <div class="file-source">
		        	<pre class="brush: php; highlight: [<?=$trace['line']?>];"><?=htmlspecialchars(file_get_contents($trace['file']))?></pre>
		        </div>
			</div>
			<?php endforeach;?>
		</div>
		<?php endforeach;?>
	</div>

	<script>
    SyntaxHighlighter.defaults.toolbar = false;
    SyntaxHighlighter.defaults['auto-links'] = false;    
    SyntaxHighlighter.all();
    </script>
</body>
</html>