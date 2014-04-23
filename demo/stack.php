<?php
require __DIR__ . '/../vendor/autoload.php';

// "test" output will be discarded.
echo 'test';

function stacka () {
    stack('a');
}

function stackb () {
    stack('b');
}

stacka();
stackb();