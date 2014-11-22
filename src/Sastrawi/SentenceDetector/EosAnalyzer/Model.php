<?php
/**
 * Sastrawi Sentence Detector (https://github.com/sastrawi/sentence-detector)
 *
 * @link      http://github.com/sastrawi/sentence-detector for the canonical source repository
 * @license   https://github.com/sastrawi/sentence-detector/blob/master/LICENSE The MIT License (MIT)
 */

namespace Sastrawi\SentenceDetector\EosAnalyzer;

/**
 * End Of Sentence Model
 *
 * @author Andy Librian
 */
class Model
{
    /**
     * @var string
     */
    private $text;

    /**
     * @var int[]
     */
    private $eosPositions = array();

    /**
     * @var int
     */
    private $position;

    /**
     * @param $text string
     * @param $eosPositions int[]
     * @param $position int
     *
     * Constructor
     */
    public function __construct($text, array $eosPositions, $position)
    {
        $this->text = $text;
        $this->eosPositions = $eosPositions;
        $this->position = $position;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @return int[]
     */
    public function getEosPositions()
    {
        return $this->eosPositions;
    }

    /**
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }
}
