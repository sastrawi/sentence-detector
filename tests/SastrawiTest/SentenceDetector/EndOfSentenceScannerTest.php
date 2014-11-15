<?php

namespace SastrawiTest\SentenceDetector;

use Sastrawi\SentenceDetector\EndOfSentenceScanner;
use Sastrawi\SentenceDetector\EndOfSentenceScannerInterface;

class EndOfSentenceScannerTest extends \PHPUnit_Framework_TestCase
{
    private $scanner;

    public function setUp()
    {
        $this->scanner = new EndOfSentenceScanner();
    }

    public function testImplementsEndOfSentenceScannerInterface()
    {
        $this->assertInstanceOf('Sastrawi\SentenceDetector\EndOfSentenceScannerInterface', $this->scanner);
    }

    public function testDefaultEndOfSentenceCharacters()
    {
        $default = array('.', '?', '!');

        $this->assertEquals($default, $this->scanner->getEndOfSentenceCharacters());
    }

    public function testGetEndOfSentenceCharsReturnPassedConstructorParam()
    {
        $chars = array(';');

        $scanner = new EndOfSentenceScanner($chars);
        $this->assertEquals($chars, $scanner->getEndOfSentenceCharacters());
    }

    public function testGetPositions()
    {
        $eosPositions = $this->scanner->getPositions('... Dia bertanya, "mengapa ?!"');

        $this->assertEquals(0, $eosPositions[0]);
        $this->assertEquals(1, $eosPositions[1]);
        $this->assertEquals(2, $eosPositions[2]);

        $this->assertEquals(27, $eosPositions[3]);
        $this->assertEquals(28, $eosPositions[4]);
    }
}
