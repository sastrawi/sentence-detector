<?php

require_once __DIR__.'/../vendor/autoload.php';

// create sentence detector
$sentenceDetectorFactory = new \Sastrawi\SentenceDetector\SentenceDetectorFactory();
$sentenceDetector = $sentenceDetectorFactory->createSentenceDetector();

// detect sentence
$text = 'Saya belajar NLP Bahasa Indonesia. Saya sedang belajar melakukan segmentasi kalimat.';
$sentences = $sentenceDetector->detect($text);

foreach ($sentences as $i => $sentence) {
    echo "$i : $sentence<br />\n";
}
