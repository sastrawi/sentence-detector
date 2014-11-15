<?php

namespace Sastrawi\SentenceDetector;

class EndOfSentenceScanner implements EndOfSentenceScannerInterface
{
    private $eosChars;

    public function __construct(array $eosChars = array('.', '?', '!'))
    {
        $this->eosChars = $eosChars;
    }

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

    public function getEndOfSentenceCharacters()
    {
        return $this->eosChars;
    }
}
