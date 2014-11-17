<?php

namespace SastrawiTest\SentenceDetector;

use Sastrawi\SentenceDetector\SentenceDetector;
use Sastrawi\SentenceDetector\Util\Span;

class SentenceDetectorTest extends \PHPUnit_Framework_TestCase
{
    private $sd;

    public function setUp()
    {
        $this->sd = new SentenceDetector();
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

    public function testDetectReturnArrayOfString()
    {
        $s = $this->sd->detect('Saya belajar NLP Bahasa Indonesia. Saya sedang segmentasi kalimat.');

        $this->assertCount(2, $s);
        $this->assertEquals('Saya belajar NLP Bahasa Indonesia.', $s[0]);
        $this->assertEquals('Saya sedang segmentasi kalimat.', $s[1]);
    }
}