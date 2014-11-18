<?php
/**
 * Sastrawi Sentence Detector (https://github.com/sastrawi/sentence-detector)
 *
 * @link      http://github.com/sastrawi/sentence-detector for the canonical source repository
 * @license   https://github.com/sastrawi/sentence-detector/blob/master/LICENSE The MIT License (MIT)
 */

namespace Sastrawi\SentenceDetector\Util;

/**
 * String utility class.
 *
 * @author Andy Librian
 */
class StringUtil
{
    private static $whitespaceChars = array(' ', "\t", "\n");

    /**
     * Determine wether a character is a whitespace or not.
     *
     * @param  string $char Character in question.
     * @return bool   True if a character is a whitespace
     */
    public static function isWhitespace($char)
    {
        return (array_search($char, self::$whitespaceChars) !== false);
    }

    /**
     * Get next first whitespace character.
     *
     * @param  string    $string Text to search whitespace character
     * @param  int       $start  Position index to start from
     * @return false|int Return the position of next first whitespace character. False if not found.
     */
    public static function getNextWhitespace($string, $start = -1)
    {
        while ($start < (strlen($string) - 1) && !self::isWhitespace($string[$start + 1])) {
            $start++;
        }

        if ($start === (strlen($string) - 1)) {
            return false;
        }

        $start++;

        return $start;
    }

    /**
     * Get previous first whitespace character.
     *
     * @param  string    $string Text to search whitespace character
     * @param  int       $start  Position index to start from
     * @return false|int Return the position of previous first whitespace character. False if not found.
     */
    public static function getPrevWhitespace($string, $start = null)
    {
        $start = ($start !== null) ? $start : strlen($string);

        while ($start > 0 && !self::isWhitespace($string[$start - 1])) {
            $start--;
        }

        if ($start === 0) {
            return false;
        }

        $start--;

        return $start;
    }

    /**
     * Get next first non whitespace character.
     *
     * @param  string    $string Text to search non whitespace character
     * @param  int       $start  Position index to start from
     * @return false|int Return the position of next first non whitespace character. False if not found.
     */
    public static function getNextNonWhitespace($string, $start = -1)
    {
        while ($start < (strlen($string) - 1) && self::isWhitespace($string[$start + 1])) {
            $start++;
        }

        if ($start === (strlen($string) - 1)) {
            return false;
        }

        $start++;

        return $start;
    }

    /**
     * Get previous first non whitespace character.
     *
     * @param  string    $string Text to search non whitespace character
     * @param  int       $start  Position index to start from
     * @return false|int Return the position of previous first non whitespace character. False if not found.
     */
    public static function getPrevNonWhitespace($string, $start = null)
    {
        $start = ($start !== null) ? $start : strlen($string);

        while ($start > 0 && self::isWhitespace($string[$start - 1])) {
            $start--;
        }

        if ($start === 0) {
            return false;
        }

        $start--;

        return $start;
    }
}
