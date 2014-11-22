<?php
/**
 * Sastrawi Sentence Detector (https://github.com/sastrawi/sentence-detector)
 *
 * @link      http://github.com/sastrawi/sentence-detector for the canonical source repository
 * @license   https://github.com/sastrawi/sentence-detector/blob/master/LICENSE The MIT License (MIT)
 */

namespace Sastrawi\SentenceDetector;

use Sastrawi\SentenceDetector\Dictionary\DictionaryInterface;
use Sastrawi\SentenceDetector\Util\StringUtil;

/**
 * Fuzzy End of Sentence Scanner.
 *
 * @author Andy Librian
 */
class FuzzyEndOfSentenceScanner implements EndOfSentenceScannerInterface
{
    /**
     * @var \Sastrawi\SentenceDetector\EndOfSentenceScanner
     */
    private $defaultScanner;

    /**
     * Abbreviation Dictionary.
     *
     * @var \Sastrawi\SentenceDetector\Dictionary\DictionaryInterface
     */
    private $abbreviationDictionary;

    /**
     * Constructor
     */
    public function __construct(DictionaryInterface $abbreviationDictionary)
    {
        $this->defaultScanner = new EndOfSentenceScanner();
        $this->abbreviationDictionary = $abbreviationDictionary;
    }

    /**
     * {@inheritdoc}
     */
    public function getPositions($string)
    {
        $enders = $this->defaultScanner->getPositions($string);

        $candidates = array();

        for ($i = 0; $i < count($enders); $i++) {
            if ($i < count($enders)-1 && $enders[$i+1] == $enders[$i]+1) {
                continue;
            }

            if ($this->shouldSplit($string, $enders, $enders[$i])) {
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

            $tokenStart = ($prevWs === false) ? 0 : $prevWs + 1;
            $tokenEnd   = (($nextWs === false) ? strlen($text) : $nextWs) - 1;

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

            $tokenStart = ($prevWs === false) ? 0 : $prevWs + 1;
            $tokenEnd   = (($nextWs === false) ? strlen($text) : $nextWs) - 1;

            $token  = substr($text, $tokenStart, $tokenEnd - $tokenStart);
            if ($token !== '' && filter_var($token, FILTER_VALIDATE_EMAIL)) {
                return false;
            }
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function getEndOfSentenceCharacters()
    {
        return $this->defaultScanner->getEndOfSentenceCharacters();
    }
}
