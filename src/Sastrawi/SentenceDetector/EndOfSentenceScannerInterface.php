<?php

namespace Sastrawi\SentenceDetector;

interface EndOfSentenceScannerInterface
{
    public function getEndOfSentenceCharacters();

    public function getPositions($string);
}
