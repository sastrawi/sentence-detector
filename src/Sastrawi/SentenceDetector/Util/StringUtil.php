<?php

namespace Sastrawi\SentenceDetector\Util;

class StringUtil
{
    private static $whitespaceChars = array(' ', "\t", "\n");

    public static function isWhitespace($char)
    {
        return (array_search($char, self::$whitespaceChars) !== false);
    }
}
