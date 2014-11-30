<?php
/**
 * Sastrawi Sentence Detector (https://github.com/sastrawi/sentence-detector)
 *
 * @link      http://github.com/sastrawi/sentence-detector for the canonical source repository
 * @license   https://github.com/sastrawi/sentence-detector/blob/master/LICENSE The MIT License (MIT)
 */

namespace Sastrawi\SentenceDetector;

/**
 * Sentence Detector Factory
 *
 * @author Andy Librian
 */
class SentenceDetectorFactory
{
    /**
     * Create a ready-to-use sentence detector instance.
     *
     * @return \Sastrawi\SentenceDetector\SentenceDetector
     */
    public function createSentenceDetector()
    {
        $eosScanner = new FuzzyEndOfSentenceScanner();
        $sentenceDetector = new SentenceDetector($eosScanner);

        return $sentenceDetector;
    }
}
