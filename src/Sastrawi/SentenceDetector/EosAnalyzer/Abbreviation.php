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

        if ($position != 0) {
            // detect wether preceding token is an abbreviation
            $start = $model->getPosition();
            while ($start > 0 && !StringUtil::isWhitespace($text[$start - 1])) {
                $start--;
            }

            $precedingToken = substr($model->getText(), $start, $position - $start);

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

        return true;
    }
}
