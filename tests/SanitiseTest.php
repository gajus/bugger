<?php
class SanitiseTest extends PHPUnit_Framework_TestCase {

    protected $sanitise;

    public function setUp() {
        $class = new ReflectionClass('Gajus\Bugger\Bugger');

        $this->sanitise = $class->getMethod('sanitise');
        $this->sanitise->setAccessible(true);
    }

    public function sanitise($argument) {
        return $this->sanitise->invoke('Gajus\Bugger\Bugger', $argument);
    }

    public function testAscii () {
        $this->assertSame('az09', $this->sanitise('az09'));
    }

    public function testUnicodeCharacters () {
        $this->assertSame('çüöйȝîûηыეமிᚉ⠛', $this->sanitise('çüöйȝîûηыეமிᚉ⠛'));
    }

    public function testControlCharacter () {
        $this->assertSame('\03', $this->sanitise("\003")); /* http://en.wikipedia.org/wiki/C0_and_C1_control_codes#C0_.28ASCII_and_derivatives.29*/
    }

    public function testUnicodeSymbol () {
        $this->assertSame('⛷⛸⛂☃⛇❄❅❆★☆⚑⚐', $this->sanitise('⛷⛸⛂☃⛇❄❅❆★☆⚑⚐'));
    }
}
