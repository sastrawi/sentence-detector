<?php
/**
 * Sastrawi Sentence Detector (https://github.com/sastrawi/sentence-detector)
 *
 * @link      http://github.com/sastrawi/sentence-detector for the canonical source repository
 * @license   https://github.com/sastrawi/sentence-detector/blob/master/LICENSE The MIT License (MIT)
 */

namespace Sastrawi\SentenceDetector\Util;

class StringUtil
{
    private static $whitespaceChars = array(' ', "\t", "\n");

    public static function isWhitespace($char)
    {
        return (array_search($char, self::$whitespaceChars) !== false);
    }
}
