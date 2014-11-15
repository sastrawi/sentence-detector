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
}
