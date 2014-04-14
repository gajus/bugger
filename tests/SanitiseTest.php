<?php
class SanitiseTest extends PHPUnit_Framework_TestCase {
    public function testSetAccess () {
        $class = new ReflectionClass('Gajus\Bugger\Bugger');
        $method = $class->getMethod('sanitise');
        $method->setAccessible(true);
        return $method;
    }

    /**
     * @depends testSetAccess
     */
    public function testAscii ($method) {
        $this->assertSame('az09', $method->invoke('Gajus\Bugger\Bugger', 'az09'));
    }

    /**
     * @depends testSetAccess
     */
    public function testUnicodeCharacters ($method) {
        $this->assertSame('çüöйȝîûηыეமிᚉ⠛', $method->invoke('Gajus\Bugger\Bugger', 'çüöйȝîûηыეமிᚉ⠛'));
    }

    /**
     * @depends testSetAccess
     */
    public function testControlCharacter ($method) {
        $this->assertSame('\03', $method->invoke('Gajus\Bugger\Bugger', "\003")); /* http://en.wikipedia.org/wiki/C0_and_C1_control_codes#C0_.28ASCII_and_derivatives.29*/
    }

    /**
     * @depends testSetAccess
     */
    public function testUnicodeSymbol ($method) {
        $this->assertSame('⛷⛸⛂☃⛇❄❅❆★☆⚑⚐', $method->invoke('Gajus\Bugger\Bugger', '⛷⛸⛂☃⛇❄❅❆★☆⚑⚐'));
    }
}