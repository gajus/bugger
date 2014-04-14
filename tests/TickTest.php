<?php
class TickTest extends PHPUnit_Framework_TestCase {
    public function testTickDefaultNamespace () {
        $i = 1000;
        
        while (--$i > 0) {
            if (tick(100)) {
                break;
            }
        }

        $this->assertCount(900, $i);
    }
}