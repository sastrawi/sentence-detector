<?php

namespace SastrawiTest\SentenceDetector;

use Sastrawi\SentenceDetector\SentenceDetectorFactory;
use Sastrawi\SentenceDetector\SentenceDetector;

class SentenceDetectorFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateSentenceDetector()
    {
        $factory = new SentenceDetectorFactory();
        $sd = $factory->createSentenceDetector();

        $this->assertInstanceOf('Sastrawi\SentenceDetector\SentenceDetector', $sd);
    }
}
