<?php
require __DIR__ . '/../bootstrap.php';

echo 'foo';

ob_start();

echo 'bar';

bump('test');