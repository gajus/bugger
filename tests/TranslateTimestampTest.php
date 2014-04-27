<?php
class TranslateTimestampTest extends PHPUnit_Framework_TestCase {
    public function testSetAccess () {
        $class = new ReflectionClass('Gajus\Bugger\Bugger');
        $method = $class->getMethod('translateTimestamp');
        $method->setAccessible(true);
        return $method;
    }

    /**
     * @depends testSetAccess
     */
    public function testOutOfRange ($method) {
        $this->assertSame('int(' . mktime(0,0,0,1,1,1999) . ')', $method->invoke('Gajus\Bugger\Bugger', 'int(' . mktime(0,0,0,1,1,1999) . ')'));
        $this->assertSame('int(' . mktime(0,0,0,1,1,2021) . ')', $method->invoke('Gajus\Bugger\Bugger', 'int(' . mktime(0,0,0,1,1,2021) . ')'));

        $this->assertSame('int ' . mktime(0,0,0,1,1,1999), $method->invoke('Gajus\Bugger\Bugger', 'int ' . mktime(0,0,0,1,1,1999)));
        $this->assertSame('int ' . mktime(0,0,0,1,1,2021), $method->invoke('Gajus\Bugger\Bugger', 'int ' . mktime(0,0,0,1,1,2021)));
    }

    /**
     * @depends testSetAccess
     */
    public function testInRange ($method) {
        $this->assertSame('int(1262304000) <== 2010-01-01 00:00:00', $method->invoke('Gajus\Bugger\Bugger', 'int(' . mktime(0,0,0,1,1,2010) . ')'));

        $this->assertSame('int 1262304000 <== 2010-01-01 00:00:00', $method->invoke('Gajus\Bugger\Bugger', 'int ' . mktime(0,0,0,1,1,2010)));
    }
}
