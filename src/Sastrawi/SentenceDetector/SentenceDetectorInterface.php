<?php
/**
 * Sastrawi Sentence Detector (https://github.com/sastrawi/sentence-detector)
 *
 * @link      http://github.com/sastrawi/sentence-detector for the canonical source repository
 * @license   https://github.com/sastrawi/sentence-detector/blob/master/LICENSE The MIT License (MIT)
 */

namespace Sastrawi\SentenceDetector;

/**
 * Sentence Detector Interface.
 *
 * @since  0.1.0
 * @author Andy Librian
 */
interface SentenceDetectorInterface
{
    /**
     * Detect sentences from any given text.
     *
     * @param  string   $text The text to detect sentence from.
     * @return string[] Detected sentences from the text.
     *
     * @api
     */
    public function detect($text);

    /**
     * Detect positions of sentences from any given text.
     *
     * @param  string                                 $text The text to detect its sentence position from.
     * @return \Sastrawi\SentenceDetector\Util\Span[] Detected sentence positions from the thext.
     *
     * @api
     */
    public function detectPositions($text);
}
