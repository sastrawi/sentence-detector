<?php
/**
 * Sastrawi Sentence Detector (https://github.com/sastrawi/sentence-detector)
 *
 * @link      http://github.com/sastrawi/sentence-detector for the canonical source repository
 * @license   https://github.com/sastrawi/sentence-detector/blob/master/LICENSE The MIT License (MIT)
 */

namespace Sastrawi\SentenceDetector\EosAnalyzer;

/**
 * Leading end of sentence analyzer
 *
 * @author Andy Librian
 */
class LeadingEos implements AnalyzerInterface
{
    /**
     * {@inheritdoc}
     */
    public function shouldSplit(Model $model)
    {
        if (trim(substr($model->getText(), 0, $model->getPosition())) === '') {
            return false;
        }

        return true;
    }
}
