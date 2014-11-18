<?php

namespace SastrawiTest\SentenceDetector\Util;

use Sastrawi\SentenceDetector\Util\StringUtil;

class StringUtilTest extends \PHPUnit_Framework_TestCase
{
    public function testIsWhitespace()
    {
        $this->assertEquals(true, StringUtil::isWhitespace(' '));
        $this->assertEquals(true, StringUtil::isWhitespace("\t"));
        $this->assertEquals(true, StringUtil::isWhitespace("\n"));
    }

    public function testGetNextWhitespace()
    {
        $this->assertSame(false, StringUtil::getNextWhitespace('Saya'));
        $this->assertEquals(4, StringUtil::getNextWhitespace('Saya belajar segmentasi kalimat.'));
        $this->assertEquals(12, StringUtil::getNextWhitespace('Saya belajar segmentasi kalimat.', 5));

        // exclusive current position
        $this->assertSame(2, StringUtil::getNextWhitespace(' S aya', 0));
    }

    public function testGetPrevWhitespace()
    {
        $this->assertSame(false, StringUtil::getPrevWhitespace('Saya'));
        $this->assertSame(0, StringUtil::getPrevWhitespace(' '));
        $this->assertEquals(10, StringUtil::getPrevWhitespace('segmentasi kalimat'));
        $this->assertEquals(12, StringUtil::getPrevWhitespace('Saya belajar segmentasi kalimat.', 15));

        // exclusive current position
        $this->assertEquals(4, StringUtil::getPrevWhitespace('Saya belajar segmentasi kalimat.', 12));
    }

    public function testGetNextNonWhitespace()
    {
        $this->assertSame(false, StringUtil::getNextNonWhitespace('  '));
        $this->assertEquals(0, StringUtil::getNextNonWhitespace('Saya belajar segmentasi kalimat.'));
        $this->assertEquals(5, StringUtil::getNextNonWhitespace('Saya belajar segmentasi kalimat.', 4));

        // exclusive current position
        $this->assertSame(3, StringUtil::getNextNonWhitespace(' S aya', 1));
    }

    public function testGetPrevNonWhitespace()
    {
        $this->assertSame(false, StringUtil::getPrevNonWhitespace(' '));
        $this->assertSame(26, StringUtil::getPrevNonWhitespace('natural language processing'));
        $this->assertEquals(17, StringUtil::getPrevNonWhitespace('segmentasi kalimat'));
        $this->assertEquals(11, StringUtil::getPrevNonWhitespace('Saya belajar segmentasi kalimat.', 12));

        // exclusive current position
        $this->assertEquals(4, StringUtil::getPrevNonWhitespace('bahasa', 5));
    }
}
