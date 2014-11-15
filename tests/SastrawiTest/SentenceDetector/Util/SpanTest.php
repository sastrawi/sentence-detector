<?php

namespace SastrawiTest\SentenceDetector\Util;

use Sastrawi\SentenceDetector\Util\Span;

class SpanTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructorParamsCanBeRetrieved()
    {
        $span = new Span(0, 3, 'type');

        $this->assertEquals(0, $span->getStart());
        $this->assertEquals(3, $span->getEnd());
        $this->assertEquals('type', $span->getType());
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testStartMustBeZeroOrGreater()
    {
        $span = new Span(-1, 2);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testEndMustBeZeroOrGreater()
    {
        $span = new Span(1, -2);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testStartCannotBeGreaterThanEnd()
    {
        $span = new Span(4, 1);
    }

    public function testGetLength()
    {
        $span = new Span(1, 4);
        $this->assertEquals(3, $span->getLength());
    }

    public function testGetCoveredText()
    {
        $span = new Span(1, 3);
        $this->assertEquals('bc', $span->getCoveredText('abcdefghijklmn'));
    }
}
