<?php
require __DIR__ . '/../vendor/autoload.php';

function stacka () {
    stack('a');
}

function stackb () {
    stack('b');
}

function stackc () {
    stack('c');
}

stacka();
stackb();
stackc();