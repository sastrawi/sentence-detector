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

        // abbreviation analyzer
        $abbrs = file(__DIR__.'/../../../data/abbreviations.txt', FILE_IGNORE_NEW_LINES);
        $abbreviationDictionary = new Dictionary\ArrayDictionary($abbrs);
        $eosScanner->addEosAnalyzer(new EosAnalyzer\Abbreviation($abbreviationDictionary));

        // TLD (Top Level Domain) analyzer
        $tlds = file(__DIR__.'/../../../data/tld.txt', FILE_IGNORE_NEW_LINES);
        $eosScanner->addEosAnalyzer(new EosAnalyzer\Tld($tlds));

        $sentenceDetector = new SentenceDetector($eosScanner);

        return $sentenceDetector;
    }
}
