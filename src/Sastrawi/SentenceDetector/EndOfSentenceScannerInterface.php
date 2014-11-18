<?php
/**
 * Sastrawi Sentence Detector (https://github.com/sastrawi/sentence-detector)
 *
 * @link      http://github.com/sastrawi/sentence-detector for the canonical source repository
 * @license   https://github.com/sastrawi/sentence-detector/blob/master/LICENSE The MIT License (MIT)
 */

namespace Sastrawi\SentenceDetector;

/**
 * End of sentence scanner interface.
 *
 * @author Andy Librian
 */
interface EndOfSentenceScannerInterface
{
    /**
     * Retrieve end of sentence characters.
     *
     * @return array
     *
     * @api
     */
    public function getEndOfSentenceCharacters();

    /**
     * Get the positions of each of detected end of sentence characters.
     *
     * @return array
     *
     * @api
     */
    public function getPositions($string);
}
