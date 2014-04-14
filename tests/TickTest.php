<?php
class TickTest extends PHPUnit_Framework_TestCase {
    public function setUp () {
        \Gajus\Bugger\Bugger::resetTick();
    }

    public function testDefaultNamespace () {
        $i = 1000;
        
        while (--$i > 0) {
            if (tick(100)) {
                break;
            }
        }

        $this->assertSame(900, $i);
    }

    public function testThreeTicks () {
        $this->assertFalse(tick(3));
        $this->assertFalse(tick(3));
        $this->assertTrue(tick(3));
        $this->assertTrue(tick(3));
    }

    public function testNamespaceIsolation () {
        $i = 100;
        $a = 100;
        $b = 100;
        
        while (--$i > 0) {
            if (tick(50, 'a')) {
                $a--;
            }

            if (tick(25, 'b')) {
                $b--;
            }
        }

        $this->assertSame(50, $a);
        $this->assertSame(25, $b);
    }
}