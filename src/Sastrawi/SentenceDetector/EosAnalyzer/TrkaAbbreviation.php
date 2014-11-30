<?php
/**
 * Sastrawi Sentence Detector (https://github.com/sastrawi/sentence-detector)
 *
 * @link      http://github.com/sastrawi/sentence-detector for the canonical source repository
 * @license   https://github.com/sastrawi/sentence-detector/blob/master/LICENSE The MIT License (MIT)
 */

namespace Sastrawi\SentenceDetector\EosAnalyzer;

use Sastrawi\Trka\Finder\AbbreviationFinderFactory;

/**
 * Analyze wether an end of sentence character is the end of abbreviation
 *
 * @author Andy Librian
 */
class TrkaAbbreviation implements AnalyzerInterface
{
    private $abbreviationFinder;

    private $lastText;

    private $lastResult = array();

    public function __construct(array $abbreviations = array())
    {
        $factory = new AbbreviationFinderFactory();
        $factory->addAbbreviations($abbreviations);

        $this->abbreviationFinder = $factory->create();
    }

    /**
     * {@inheritdoc}
     */
    public function shouldSplit(Model $model)
    {
        if ($this->lastResult === null || $this->lastText !== $model->getText()) {
            $this->lastResult = $this->abbreviationFinder->find($model->getText());
            $this->lastText   = $model->getText();
        }

        foreach ($this->lastResult as $span) {
            if ($span->containsIndex($model->getPosition())) {
                return false;
            }
        }

        return true;
    }
}
