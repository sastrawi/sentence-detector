<?php

namespace SastrawiTest\SentenceDetector;

use Sastrawi\SentenceDetector\FuzzyEndOfSentenceScanner;
use Sastrawi\SentenceDetector\EndOfSentenceScannerInterface;
use Sastrawi\SentenceDetector\EosAnalyzer\Abbreviation;
use Sastrawi\SentenceDetector\EosAnalyzer\Tld;
use Sastrawi\SentenceDetector\Dictionary\ArrayDictionary;

class FuzzyEndOfSentenceScannerTest extends \PHPUnit_Framework_TestCase
{
    private $scanner;

    public function setUp()
    {
        $this->scanner = new FuzzyEndOfSentenceScanner();
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

    public function testGetPositions()
    {
        $eosPositions = $this->scanner->getPositions('... Dia bertanya, "mengapa ?!"');

        $this->assertEquals(2, $eosPositions[0]);
        $this->assertEquals(28, $eosPositions[1]);
    }

    public function testAddGetEosAnalyzers()
    {
        $this->assertCount(4, $this->scanner->getEosAnalyzers());

        $mock = $this->getMock('Sastrawi\SentenceDetector\EosAnalyzer\AnalyzerInterface');
        $this->scanner->addEosAnalyzers(array($mock));
        $this->assertCount(5, $this->scanner->getEosAnalyzers());
    }

    public function testGetPositionsNumeric()
    {
        $eosPositions = $this->scanner->getPositions('Rp 2.500.000.');

        $this->assertEquals(12, $eosPositions[0]);
    }

    public function testGetPositionsEmailAddress()
    {
        $eosPositions = $this->scanner->getPositions('andy.librian@gmail.com.');

        $this->assertEquals(22, $eosPositions[0]);
    }

    public function testGetPositionAbbreviation()
    {
        $dictionary = new ArrayDictionary(array('jl'));
        $abbreviationAnalyzer = new Abbreviation($dictionary);

        $this->scanner->addEosAnalyzer($abbreviationAnalyzer);
        $eosPositions = $this->scanner->getPositions('Jl. Hayam Wuruk.');

        $this->assertEquals(15, $eosPositions[0]);
    }

    public function testGetPositionTld()
    {
        $tldAnalyzer = new Tld(array('.io'));

        $this->scanner->addEosAnalyzer($tldAnalyzer);
        $eosPositions = $this->scanner->getPositions('sastrawi.github.io.');

        $this->assertEquals(18, $eosPositions[0]);
    }
}
