<?php

namespace SastrawiTest\SentenceDetector;

use Sastrawi\SentenceDetector\SentenceDetector;
use Sastrawi\SentenceDetector\Util\Span;
use Sastrawi\SentenceDetector\EndOfSentenceScanner;
use Sastrawi\SentenceDetector\Dictionary\ArrayDictionary;

class SentenceDetectorTest extends \PHPUnit_Framework_TestCase
{
    private $sd;

    public function setUp()
    {
        $eosScanner = new EndOfSentenceScanner();
        $abbreviationDictionary = new ArrayDictionary();
        $this->sd = new SentenceDetector($eosScanner, $abbreviationDictionary);
    }

    public function testImplementsProperInterface()
    {
        $this->assertInstanceOf('Sastrawi\SentenceDetector\SentenceDetectorInterface', $this->sd);
    }

    public function testDetectPositionsReturnArrayOfSpan()
    {
        $spans = $this->sd->detectPositions('Saya belajar NLP Bahasa Indonesia. Saya sedang segmentasi kalimat.');

        $this->assertCount(2, $spans);
        $this->assertEquals(new Span(0, 34), $spans[0]);
        $this->assertEquals(new Span(35, 66), $spans[1]);
    }

    public function testDetectPositionsWhenTheTextContainsNoEndOfSentence()
    {
        $spans = $this->sd->detectPositions('Saya belajar NLP Bahasa Indonesia');

        $this->assertCount(1, $spans);
        $this->assertEquals(new Span(0, 33), $spans[0]);
    }

    public function testDetectReturnArrayOfString()
    {
        $s = $this->sd->detect('Saya belajar NLP Bahasa Indonesia. Saya sedang segmentasi kalimat.');

        $this->assertCount(2, $s);
        $this->assertEquals('Saya belajar NLP Bahasa Indonesia.', $s[0]);
        $this->assertEquals('Saya sedang segmentasi kalimat.', $s[1]);
    }
}
