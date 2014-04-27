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
    <?=file_get_contents(__DIR__ . '/static/js/bugger.js')?>
    <?=file_get_contents(__DIR__ . '/static/js/syntaxhighlighter/scripts/shCore.js')?>
    <?=file_get_contents(__DIR__ . '/static/js/syntaxhighlighter/scripts/shBrushPhp.js')?>
    </script>
</head>
<body>
    <div id="bugger" style="width: <?=count($tracestack) * 610?>px">
        <?php foreach ($tracestack as $s => $stack):?>
        <div class="trace s-<?=$s?>">
            <?php foreach ($stack as $t => $trace):?>
            <div class="card t-<?=$t?>">
                <div class="header">
                    <?=$trace['file']?>
                </div>
                <?php if ($trace['args_dump']) { ?>
                <div class="dump">
                    <?php foreach ($trace['args_dump'] as $i => $argdump) { ?>
                        <p class="argument-label">Argument <?= ($i + 1) ?>:</p>
                        <pre class="brush: php; gutter: false;">
                        <?=$argdump?>
                        </pre>
                    <?php } // endforeach ?>
                </div>
                <?php } // endif ?>
                <div class="file-source collapsed">
                    <pre class="brush: php; highlight: [<?=$trace['line']?>];"><?=htmlspecialchars(file_get_contents($trace['file']))?></pre>
                </div>
            </div>
            <?php endforeach;?>
        </div>
        <?php endforeach;?>
    </div>

    <style>
    .file-source.collapsed { height: 60px; overflow: hidden; }
    .file-source.collapsed > div { position: relative; }

    <?php foreach ($tracestack as $s => $stack):?>
        <?php foreach ($stack as $t => $trace): ?>
        .trace.s-<?=$s?> .card.t-<?=$t?> .file-source.collapsed > div { top: -<?=($trace['line'] - 1) * 20 - 10?>px; }
        <?php endforeach;?>
    <?php endforeach;?>
    </style>

    <script>
    SyntaxHighlighter.defaults.toolbar = false;
    SyntaxHighlighter.defaults['auto-links'] = false;
    SyntaxHighlighter.all();
    </script>
</body>
</html>
