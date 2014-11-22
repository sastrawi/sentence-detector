<?php
/**
 * Sastrawi Sentence Detector (https://github.com/sastrawi/sentence-detector)
 *
 * @link      http://github.com/sastrawi/sentence-detector for the canonical source repository
 * @license   https://github.com/sastrawi/sentence-detector/blob/master/LICENSE The MIT License (MIT)
 */

namespace Sastrawi\SentenceDetector;

use Sastrawi\SentenceDetector\Util\StringUtil;
use Sastrawi\SentenceDetector\Util\Span;

/**
 * Sentence Detector for Bahasa Indonesia.
 *
 * @author Andy Librian
 */
class SentenceDetector implements SentenceDetectorInterface
{
    /**
     * End of sentence scanner.
     *
     * @var \Sastrawi\SentenceDetector\EndOfSentenceScannerInterface
     */
    private $eosScanner;

    /**
     * Constructor.
     */
    public function __construct(EndOfSentenceScannerInterface $eosScanner)
    {
        $this->eosScanner = $eosScanner;
    }

    /**
     * {@inheritdoc}
     */
    public function detect($text)
    {
        $spans = $this->detectPositions($text);
        $sentences = array();

        foreach ($spans as $span) {
            $sentences[] = $span->getCoveredText($text);
        }

        return $sentences;
    }

    /**
     * {@inheritdoc}
     */
    public function detectPositions($text)
    {
        $positions = $this->detectEosCandidates($text);
        $spans     = array();

        // string does not contain any sentence end positions
        if (count($positions) == 0) {
            $start = StringUtil::getNextNonWhitespace($text);
            $end   = StringUtil::getPrevNonWhitespace($text);

            if (($end - $start) > 0) {
                $spans[] = new Span($start, $end + 1);
            }

            return $spans;
        }

        // convert positions to spans
        $spans = array();
        foreach ($positions as $i => $pos) {
            // first sentence starts from 0, else starts from $pos[$i-1] + 1
            if ($i == 0) {
                $start = StringUtil::getNextNonWhitespace($text);
            } else {
                // start from previous eos position + 1
                $start = $positions[$i - 1] + 1;

                // ignore closing quote if exist
                if (substr($text, $positions[$i - 1] + 1, 1) === '"') {
                    $start++;
                }

                $start = StringUtil::getNextNonWhitespace($text, $start - 1);
            }

            $end = StringUtil::getPrevNonWhitespace($text, $pos);
            $end++;
            // include closing quote if exist
            if ($end < strlen($text) - 1) {
                if (substr($text, $end + 1, 1) === '"') {
                    $end++;
                }
            }

            // .   .   .
            if ($end < $start) {
                $end = $start;
            }

            $spans[] = new Span($start, $end + 1);
        }

        // leftover
        if ($positions[count($positions) - 1] != strlen($text) - 1) {
            $start = StringUtil::getNextNonWhitespace($text, $positions[count($positions) - 1]);
            $end   = StringUtil::getPrevNonWhitespace($text);

            if ($start !== false && ($end - $start) > 0) {
                $spans[] = new Span($start, $end + 1);
            }
        }

        return $spans;
    }

    private function detectEosCandidates($text)
    {
        return $this->eosScanner->getPositions($text);
    }
}
