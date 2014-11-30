<?php
/**
 * Sastrawi Sentence Detector (https://github.com/sastrawi/sentence-detector)
 *
 * @link      http://github.com/sastrawi/sentence-detector for the canonical source repository
 * @license   https://github.com/sastrawi/sentence-detector/blob/master/LICENSE The MIT License (MIT)
 */

namespace Sastrawi\SentenceDetector;

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
     * @var \Sastrawi\SentenceDetector\EosAnalyzer\AnalyzerInterface[]
     */
    private $eosAnalyzers = array();

    /**
     * Constructor
     */
    public function __construct(array $eosAnalyzers = array())
    {
        $this->defaultScanner = new EndOfSentenceScanner();

        $this->addEosAnalyzer(new EosAnalyzer\RepetitiveEos());
        $this->addEosAnalyzer(new EosAnalyzer\LeadingEos());
        $this->addEosAnalyzer(new EosAnalyzer\TrkaNumericSeparator());
        $this->addEosAnalyzer(new EosAnalyzer\TrkaEmailAddress());
        $this->addEosAnalyzer(new EosAnalyzer\TrkaAbbreviation());
        $this->addEosAnalyzer(new EosAnalyzer\TrkaHostname());
        $this->addEosAnalyzer(new EosAnalyzer\TrkaUrl());

        $this->addEosAnalyzers($eosAnalyzers);
    }

    /**
     * Add analyzers
     *
     * @param \Sastrawi\SentenceDetector\EosAnalyzer\AnalyzerInterface[]
     */
    public function addEosAnalyzers(array $eosAnalyzers)
    {
        foreach ($eosAnalyzers as $analyzer) {
            $this->addEosAnalyzer($analyzer);
        }
    }

    /**
     * Add analyzer
     *
     * @param \Sastrawi\SentenceDetector\EosAnalyzer\AnalyzerInterface
     */
    public function addEosAnalyzer(EosAnalyzer\AnalyzerInterface $analyzer)
    {
        $this->eosAnalyzers[] = $analyzer;
    }

    /**
     * Get registered analyzers
     *
     * @return \Sastrawi\SentenceDetector\EosAnalyzer\AnalyzerInterface[]
     */
    public function getEosAnalyzers()
    {
        return $this->eosAnalyzers;
    }

    /**
     * {@inheritdoc}
     */
    public function getPositions($string)
    {
        $enders = $this->defaultScanner->getPositions($string);

        $candidates = array();

        for ($i = 0; $i < count($enders); $i++) {
            if ($this->shouldSplit($string, $enders, $enders[$i])) {
                $candidates[] = $enders[$i];
            }
        }

        return $candidates;
    }

    private function shouldSplit($text, array $eosPositions, $position)
    {
        $model = new EosAnalyzer\Model($text, $eosPositions, $position);

        foreach ($this->eosAnalyzers as $analyzer) {
            if ($analyzer->shouldSplit($model) === false) {
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
