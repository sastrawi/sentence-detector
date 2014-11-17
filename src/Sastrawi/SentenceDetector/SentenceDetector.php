<?php
/**
 * Sastrawi Sentence Detector (https://github.com/sastrawi/sentence-detector)
 *
 * @link      http://github.com/sastrawi/sentence-detector for the canonical source repository
 * @license   https://github.com/sastrawi/sentence-detector/blob/master/LICENSE The MIT License (MIT)
 */

namespace Sastrawi\SentenceDetector;

use Sastrawi\SentenceDetector\Util\StringUtil;
use Sastrawi\SentenceDetector\Util\Span;

class SentenceDetector implements SentenceDetectorInterface
{
    private $eosScanner;

    private $abbreviationDictionary;

    public function __construct()
    {
        $this->eosScanner = new EndOfSentenceScanner();
        $abbrs = file(__DIR__.'/../../../data/abbreviations.txt', FILE_IGNORE_NEW_LINES);
        $this->abbreviationDictionary = new Dictionary\ArrayDictionary($abbrs);
    }

    public function detect($text)
    {
        $spans = $this->detectPositions($text);
        $sentences = array();

        foreach ($spans as $span) {
            $sentences[] = $span->getCoveredText($text);
        }

        return $sentences;
    }

    public function detectPositions($text)
    {
        $positions = $this->detectEosCandidates($text);
        $spans     = array();

        // string does not contain any sentence end positions
        if (count($positions) == 0) {
            $start = $this->getFirstNonWhitespace($text, 0);
            $end   = $this->getFirstNonWhitespace($text, strlen($text), -1);

            if (($end - $start) > 0) {
                $spans[] = new Span($start, $end);
            }

            return $spans;
        }

        // convert positions to spans
        $spans = array();
        foreach ($positions as $i => $pos) {
            // first sentence starts from 0, else starts from $pos[$i-1] + 1
            if ($i == 0) {
                $start = $this->getFirstNonWhitespace($text, 0);
            } else {
                $start = $this->getFirstNonWhitespace($text, $positions[$i - 1] + 1);
            }

            $end = $this->getFirstNonWhitespace($text, $pos, -1);
            $end++;

            $spans[] = new Span($start, $end);
        }

        // leftover
        if ($positions[count($positions) - 1] != strlen($text)) {
            $start = $this->getFirstNonWhitespace($text, $positions[count($positions) - 1] + 1);
            $end   = $this->getFirstNonWhitespace($text, strlen($text), -1);

            if (($end - $start) > 0) {
                $spans[] = new Span($start, $end);
            }
        }

        return $spans;
    }

    private function detectEosCandidates($text)
    {
        $enders = $this->eosScanner->getPositions($text);
        $candidates = array();

        for ($i = 0; $i < count($enders); $i++) {
            if ($i < count($enders)-1 && $enders[$i+1] == $enders[$i]+1) {
                continue;
            }

            if ($this->shouldSplit($text, $enders, $enders[$i])) {
                $candidates[] = $enders[$i];
            }
        }

        return $candidates;
    }

    private function shouldSplit($text, array $eosPositions, $position)
    {
        if (trim(substr($text, 0, $position)) === '') {
            return false;
        }

        if ($position != 0) {
            // detect wether preceding token is an abbreviation
            $start = $position;
            while ($start > 0 && !StringUtil::isWhitespace($text[$start - 1])) {
                $start--;
            }

            $precedingToken = substr($text, $start, $position - $start);

            if ($this->abbreviationDictionary->contains(strtolower($precedingToken))) {
                return false;
            }
        }

        return true;
    }

    private function getFirstNonWhitespace($string, $start, $direction = 1)
    {
        if ($direction > 0) {
            while ($start < strlen($string) && StringUtil::isWhitespace($string[$start])) {
                $start++;
            }
        } else {
            while ($start > 0 && StringUtil::isWhitespace($string[$start - 1])) {
                $start--;
            }
        }

        return $start;
    }
}
