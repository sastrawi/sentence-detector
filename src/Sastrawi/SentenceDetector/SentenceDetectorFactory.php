<?php

namespace Sastrawi\SentenceDetector;

class SentenceDetectorFactory
{
    public function createSentenceDetector()
    {
        $sentenceDetector = new SentenceDetector();

        return $sentenceDetector;
    }
}
