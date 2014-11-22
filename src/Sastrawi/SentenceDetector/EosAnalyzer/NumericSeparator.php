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
class NumericSeparator implements AnalyzerInterface
{
    /**
     * {@inheritdoc}
     */
    public function shouldSplit(Model $model)
    {
        $position = $model->getPosition();
        $text = $model->getText();

        if ($position != 0 && $position < strlen($text) - 1) {
            $prevChar = substr($text, $position - 1, 1);
            $nextChar = substr($text, $position + 1, 1);

            if (is_numeric($prevChar) && is_numeric($nextChar)) {
                return false;
            }
        }

        return true;
    }
}
