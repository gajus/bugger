<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="http://local:9980/gajus/2014%2001%2012%20bugger/src/inc/static/css/bugger.css">
	
	<link rel="stylesheet" type="text/css" href="http://local:9980/gajus/2014%2001%2012%20bugger/src/inc/static/css/syntaxhighlighter/shThemeDefault.css">
	<link rel="stylesheet" type="text/css" href="http://local:9980/gajus/2014%2001%2012%20bugger/src/inc/static/css/syntaxhighlighter/shCore.css">

	<script src="http://local:9980/gajus/2014%2001%2012%20bugger/src/inc/static/js/jquery-2.1.0.min.js"></script>
	<script src="http://local:9980/gajus/2014%2001%2012%20bugger/src/inc/static/js/syntaxhighlighter/scripts/shCore.js"></script>
	<script src="http://local:9980/gajus/2014%2001%2012%20bugger/src/inc/static/js/syntaxhighlighter/scripts/shBrushPhp.js"></script>
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