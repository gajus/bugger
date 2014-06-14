<?php
class TranslateTimestampTest extends PHPUnit_Framework_TestCase {

    protected $translateTimestamp;

    public function setUp() {
        $class = new ReflectionClass('Gajus\Bugger\Bugger');

        $this->translateTimestamp = $class->getMethod('translateTimestamp');
        $this->translateTimestamp->setAccessible(true);
    }

    public function translateTimestamp($argument)
    {
        return $this->translateTimestamp->invoke('Gajus\Bugger\Bugger', $argument);
    }

    public function testOutOfRange () {
        $this->assertSame('int(' . mktime(0,0,0,1,1,1999) . ')', $this->translateTimestamp('int(' . mktime(0,0,0,1,1,1999) . ')'));
        $this->assertSame('int(' . mktime(0,0,0,1,1,2021) . ')', $this->translateTimestamp('int(' . mktime(0,0,0,1,1,2021) . ')'));

        $this->assertSame('int ' . mktime(0,0,0,1,1,1999), $this->translateTimestamp('int ' . mktime(0,0,0,1,1,1999)));
        $this->assertSame('int ' . mktime(0,0,0,1,1,2021), $this->translateTimestamp('int ' . mktime(0,0,0,1,1,2021)));
    }

    public function testInRange () {
        $this->assertSame('int(1262304000) <== 2010-01-01 00:00:00', $this->translateTimestamp('int(' . mktime(0,0,0,1,1,2010) . ')'));

        $this->assertSame('int 1262304000 <== 2010-01-01 00:00:00', $this->translateTimestamp('int ' . mktime(0,0,0,1,1,2010)));
    }
}
