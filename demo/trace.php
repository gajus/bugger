<?php
require __DIR__ . '/../vendor/autoload.php';

// "test" output will be discarded.
echo 'test';

function tracea () {
    trace(time());
}

tracea();