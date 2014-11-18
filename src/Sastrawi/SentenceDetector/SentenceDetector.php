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
use Sastrawi\SentenceDetector\Dictionary\DictionaryInterface;

/**
 * Sentence Detector for Bahasa Indonesia.
 *
 * @author Andy Librian
 */
class SentenceDetector implements SentenceDetectorInterface
{
    /**
     * End of sentence scanner.
     *
     * @var \Sastrawi\SentenceDetector\EndOfSentenceScannerInterface
     */
    private $eosScanner;

    /**
     * Abbreviation Dictionary.
     *
     * @var \Sastrawi\SentenceDetector\Dictionary\DictionaryInterface
     */
    private $abbreviationDictionary;

    /**
     * Constructor.
     */
    public function __construct(
        EndOfSentenceScannerInterface $eosScanner,
        DictionaryInterface $abbreviationDictionary
    ) {
        $this->eosScanner = $eosScanner;
        $this->abbreviationDictionary = $abbreviationDictionary;
    }

    /**
     * {@inheritdoc}
     */
    public function detect($text)
    {
        $spans = $this->detectPositions($text);
        $sentences = array();

        foreach ($spans as $span) {
            $sentences[] = $span->getCoveredText($text);
        }

        return $sentences;
    }

    /**
     * {@inheritdoc}
     */
    public function detectPositions($text)
    {
        $positions = $this->detectEosCandidates($text);
        $spans     = array();

        // string does not contain any sentence end positions
        if (count($positions) == 0) {
            $start = StringUtil::getNextNonWhitespace($text);
            $end   = StringUtil::getPrevNonWhitespace($text);

            if (($end - $start) > 0) {
                $spans[] = new Span($start, $end + 1);
            }

            return $spans;
        }

        // convert positions to spans
        $spans = array();
        foreach ($positions as $i => $pos) {
            // first sentence starts from 0, else starts from $pos[$i-1] + 1
            if ($i == 0) {
                $start = StringUtil::getNextNonWhitespace($text);
            } else {
                // start from previous eos position + 1
                $start = $positions[$i - 1] + 1;

                // ignore closing quote if exist
                if (substr($text, $positions[$i - 1] + 1, 1) === '"') {
                    $start++;
                }

                $start = StringUtil::getNextNonWhitespace($text, $start - 1);
            }

            $end = StringUtil::getPrevNonWhitespace($text, $pos);
            $end++;
            // include closing quote if exist
            if ($end < strlen($text) - 1) {
                if (substr($text, $end + 1, 1) === '"') {
                    $end++;
                }
            }

            $spans[] = new Span($start, $end + 1);
        }

        // leftover
        if ($positions[count($positions) - 1] != strlen($text) - 1) {
            $start = StringUtil::getNextNonWhitespace($text, $positions[count($positions) - 1]);
            $end   = StringUtil::getPrevNonWhitespace($text);

            if ($start !== false && ($end - $start) > 0) {
                $spans[] = new Span($start, $end + 1);
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

        if ($position < strlen($text) - 1) {
            // detect wether preceding token is part of an abbreviation
            // for example: a.n., e.g., i.e., a.m.v.b.
            $nextWs = StringUtil::getNextWhitespace($text, $position);
            $prevWs = StringUtil::getPrevWhitespace($text, $position);

            $tokenStart = $prevWs + 1;
            $tokenEnd   = $nextWs - 1;

            $token  = substr($text, $tokenStart, $tokenEnd - $tokenStart);

            if ($token !== '' && strpos($token, '.') !== false) {
                if ($this->abbreviationDictionary->contains(strtolower($token))) {
                    return false;
                }
            }
        }

        // check thousand / digit separator
        if ($position != 0 && $position < strlen($text) - 1) {
            $prevChar = substr($text, $position - 1, 1);
            $nextChar = substr($text, $position + 1, 1);

            if (is_numeric($prevChar) && is_numeric($nextChar)) {
                return false;
            }
        }

        // detect email address, exclude last .
        if ($position < (strlen($text) - 1) && !StringUtil::isWhitespace(substr($text, $position + 1, 1))) {
            $nextWs = StringUtil::getNextWhitespace($text, $position);
            $prevWs = StringUtil::getPrevWhitespace($text, $position);

            $tokenStart = $prevWs + 1;
            $tokenEnd   = $nextWs - 1;

            $token  = substr($text, $tokenStart, $tokenEnd - $tokenStart);
            if ($token !== '' && filter_var($token, FILTER_VALIDATE_EMAIL)) {
                return false;
            }
        }

        return true;
    }
}
