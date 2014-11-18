<?php
/**
 * Sastrawi Sentence Detector (https://github.com/sastrawi/sentence-detector)
 *
 * @link      http://github.com/sastrawi/sentence-detector for the canonical source repository
 * @license   https://github.com/sastrawi/sentence-detector/blob/master/LICENSE The MIT License (MIT)
 */

namespace Sastrawi\SentenceDetector;

/**
 * End of Sentence Scanner.
 *
 * @author Andy Librian
 */
class EndOfSentenceScanner implements EndOfSentenceScannerInterface
{
    /**
     * @var string[]
     */
    private $eosChars;

    /**
     * Constructor
     */
    public function __construct(array $eosChars = array('.', '?', '!'))
    {
        $this->eosChars = $eosChars;
    }

    /**
     * {@inheritdoc}
     */
    public function getPositions($string)
    {
        $string    = (string) $string;
        $positions = array();

        for ($i = 0; $i < strlen($string); $i++) {
            if (array_search($string[$i], $this->eosChars) !== false) {
                $positions[] = $i;
            }
        }

        return $positions;
    }

    /**
     * {@inheritdoc}
     */
    public function getEndOfSentenceCharacters()
    {
        return $this->eosChars;
    }
}
