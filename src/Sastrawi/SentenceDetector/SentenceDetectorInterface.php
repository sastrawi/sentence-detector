<?php

namespace Sastrawi\SentenceDetector;

interface SentenceDetectorInterface
{
    public function detect($text);

    public function detectPositions($text);
}
