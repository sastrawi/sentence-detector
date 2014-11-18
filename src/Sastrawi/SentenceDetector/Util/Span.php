<?php
/**
 * Sastrawi Sentence Detector (https://github.com/sastrawi/sentence-detector)
 *
 * @link      http://github.com/sastrawi/sentence-detector for the canonical source repository
 * @license   https://github.com/sastrawi/sentence-detector/blob/master/LICENSE The MIT License (MIT)
 */

namespace Sastrawi\SentenceDetector\Util;

/**
 * Text span model
 *
 * @author Andy Librian
 */
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

    /**
     * Get the start position.
     *
     * @return int
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * Get the end position.
     *
     * @return int
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * Get type of the span.
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Get the span length
     *
     * @return int
     */
    public function getLength()
    {
        return $this->end - $this->start;
    }

    /**
     * Get covered text by this span.
     *
     * @param  string $text The text
     * @return string
     */
    public function getCoveredText($text)
    {
        return substr($text, $this->start, $this->getLength());
    }
}
