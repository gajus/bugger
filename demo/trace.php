<?php
require __DIR__ . '/../vendor/autoload.php';

ob_start();

echo 'test';

while (ob_get_level()) {
    ob_end_clean();
}

function tracea () {
    trace(time());
}

tracea();