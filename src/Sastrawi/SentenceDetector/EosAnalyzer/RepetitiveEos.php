<?php
/**
 * Sastrawi Sentence Detector (https://github.com/sastrawi/sentence-detector)
 *
 * @link      http://github.com/sastrawi/sentence-detector for the canonical source repository
 * @license   https://github.com/sastrawi/sentence-detector/blob/master/LICENSE The MIT License (MIT)
 */

namespace Sastrawi\SentenceDetector\EosAnalyzer;

/**
 * Repetitive end of sentence analyzer
 *
 * @author Andy Librian
 */
class RepetitiveEos implements AnalyzerInterface
{
    /**
     * {@inheritdoc}
     */
    public function shouldSplit(Model $model)
    {
        $eos = $model->getEosPositions();

        $i = array_search($model->getPosition(), $eos);

        if ($i === false) {
            return true;
        }

        if ($i < count($eos)-1 && $eos[$i+1] == $eos[$i]+1) {
            return false;
        }

        return true;
    }
}
