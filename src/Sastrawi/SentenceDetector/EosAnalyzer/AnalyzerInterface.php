<?php
/**
 * Sastrawi Sentence Detector (https://github.com/sastrawi/sentence-detector)
 *
 * @link      http://github.com/sastrawi/sentence-detector for the canonical source repository
 * @license   https://github.com/sastrawi/sentence-detector/blob/master/LICENSE The MIT License (MIT)
 */

namespace Sastrawi\SentenceDetector\EosAnalyzer;

/**
 * Numeric separator analyzer
 *
 * @author Andy Librian
 */
interface AnalyzerInterface
{
    /**
     * Analyze wether an end of sentence character should split the sentence or not.
     *
     * @param  \Sastrawi\SentenceDetector\EosAnalyzer\Model $model
     * @return boolean
     */
    public function shouldSplit(Model $model);
}
