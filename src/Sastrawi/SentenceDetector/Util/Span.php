<?php
/**
 * Sastrawi Sentence Detector (https://github.com/sastrawi/sentence-detector)
 *
 * @link      http://github.com/sastrawi/sentence-detector for the canonical source repository
 * @license   https://github.com/sastrawi/sentence-detector/blob/master/LICENSE The MIT License (MIT)
 */

namespace Sastrawi\SentenceDetector\Util;

class Span
{
    private $start = 0;

    private $end = 0;

    private $type;

    public function __construct($start, $end, $type = null)
    {
        if (!is_int($start) || $start < 0) {
            throw new \InvalidArgumentException("start index must be zero or greater: $start given.");
        }

        if (!is_int($end) || $end < 0) {
            throw new \InvalidArgumentException("end index must be zero or greater: $end given.");
        }

        if ($start > $end) {
            throw new \InvalidArgumentException(
                "start index can not be greater than end index: start=$start, end=$end"
            );
        }

        $this->start = $start;
        $this->end   = $end;
        $this->type  = $type;
    }

    public function getStart()
    {
        return $this->start;
    }

    public function getEnd()
    {
        return $this->end;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getLength()
    {
        return $this->end - $this->start;
    }

    public function getCoveredText($text)
    {
        return substr($text, $this->start, $this->getLength());
    }
}
