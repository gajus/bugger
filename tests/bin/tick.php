<?php
$i = 100;

while ($i--) {
    if (tick(5)) {
        bump($i); // 95
    }
}