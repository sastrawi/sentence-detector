<?php
/**
 * Sastrawi Sentence Detector (https://github.com/sastrawi/sentence-detector)
 *
 * @link      http://github.com/sastrawi/sentence-detector for the canonical source repository
 * @license   https://github.com/sastrawi/sentence-detector/blob/master/LICENSE The MIT License (MIT)
 */

namespace Sastrawi\SentenceDetector\Dictionary;

/**
 * The Dictionary interface used by sentence detector.
 *
 * @author Andy Librian
 */
interface DictionaryInterface extends \Countable
{
    /**
     * Checks whether a word is contained in the dictionary.
     *
     * @param string $word The word to search for.
     *
     * @return boolean TRUE if the dictionary contains the word, FALSE otherwise.
     */
    public function contains($word);
}
