<?php
/**
 * Sastrawi Sentence Detector (https://github.com/sastrawi/sentence-detector)
 *
 * @link      http://github.com/sastrawi/sentence-detector for the canonical source repository
 * @license   https://github.com/sastrawi/sentence-detector/blob/master/LICENSE The MIT License (MIT)
 */

namespace Sastrawi\SentenceDetector\EosAnalyzer;

use Sastrawi\SentenceDetector\Util\StringUtil;
use Sastrawi\SentenceDetector\Dictionary\DictionaryInterface;

/**
 * Analyze wether an end of sentence character is the end of abbreviation
 *
 * @author Andy Librian
 */
class Abbreviation implements AnalyzerInterface
{
    private $abbreviationDictionary;

    public function __construct(DictionaryInterface $abbreviationDictionary)
    {
        $this->abbreviationDictionary = $abbreviationDictionary;
    }

    /**
     * {@inheritdoc}
     */
    public function shouldSplit(Model $model)
    {
        $text     = $model->getText();
        $position = $model->getPosition();

        // detect wether preceding token is an abbreviation
        if ($position != 0) {
            if ($this->abbreviationDictionary->contains(strtolower($this->getPrecedingToken($text, $position)))) {
                return false;
            }
        }

        // detect wether preceding token is part of an abbreviation
        // for example: a.n., e.g., i.e., a.m.v.b.
        if ($position < strlen($text) - 1) {
            $token = $this->getToken($text, $position);

            if ($token !== '' && strpos($token, '.') !== false) {
                if ($this->abbreviationDictionary->contains(strtolower($token))) {
                    return false;
                }
            }
        }

        return true;
    }

    private function getPrecedingToken($text, $position)
    {
        $start = $position;
        while ($start > 0 && !StringUtil::isWhitespace($text[$start - 1])) {
            $start--;
        }

        $precedingToken = substr($text, $start, $position - $start);

        return $precedingToken;
    }

    private function getToken($text, $position)
    {
        if ($position >= strlen($text) - 1) {
            return '';
        }

        $nextWs = StringUtil::getNextWhitespace($text, $position);
        $prevWs = StringUtil::getPrevWhitespace($text, $position);

        $tokenStart = ($prevWs === false) ? 0 : $prevWs + 1;
        $tokenEnd   = (($nextWs === false) ? strlen($text) : $nextWs) - 1;

        $token  = substr($text, $tokenStart, $tokenEnd - $tokenStart);

        return $token;
    }
}
