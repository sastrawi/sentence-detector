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
        $eosScanner = new EndOfSentenceScanner();

        $abbrs = file(__DIR__.'/../../../data/abbreviations.txt', FILE_IGNORE_NEW_LINES);
        $dictionary = new Dictionary\ArrayDictionary($abbrs);

        $sentenceDetector = new SentenceDetector($eosScanner, $dictionary);

        return $sentenceDetector;
    }
}
