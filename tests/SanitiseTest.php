<?php
class SanitiseTest extends PHPUnit_Framework_TestCase {
    public function testAscii () {
        $this->assertSame('az09', \Gajus\Bugger\Bugger::sanitise('az09'));
    }

    public function testUnicodeCharacters () {
        $this->assertSame('çüöйȝîûηыეமிᚉ⠛', \Gajus\Bugger\Bugger::sanitise('çüöйȝîûηыეமிᚉ⠛'));
    }

    public function testControlCharacter () {
        $this->assertSame('\03', \Gajus\Bugger\Bugger::sanitise("\003")); /* http://en.wikipedia.org/wiki/C0_and_C1_control_codes#C0_.28ASCII_and_derivatives.29*/
    }

    public function testUnicodeSymbol () {
        $this->assertSame('⛷⛸⛂☃⛇❄❅❆★☆⚑⚐', \Gajus\Bugger\Bugger::sanitise('⛷⛸⛂☃⛇❄❅❆★☆⚑⚐'));
    }
}