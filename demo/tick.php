<?php
require __DIR__ . '/../vendor/autoload.php';

tick(3); // tick 1, false
tick(3); // tick 2, false
tick(3); // tick 3, true

do {
    stack('a');
} while (!tick(5));  // tick 4, tick 5