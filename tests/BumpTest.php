<?php
class BumpTest extends PHPUnit_Framework_TestCase {
    public function testBump () {
        $output = str_replace(__DIR__, '.', shell_exec('php "' . __DIR__ . '/bin/bump_test.php"'));

        $expected_output = 
'string(4) "test"
int(1390850756) <== 2014-01-27 19:25:56

Backtrace:

#0  bump(test, 1390850756) called at [./bin/bump_test.php:6]
';
        
        $this->assertSame($expected_output, $output);
    }
}

