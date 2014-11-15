<?php
/**
 * Sastrawi Sentence Detector (https://github.com/sastrawi/sentence-detector)
 *
 * @link      http://github.com/sastrawi/sentence-detector for the canonical source repository
 * @license   https://github.com/sastrawi/sentence-detector/blob/master/LICENSE The MIT License (MIT)
 */

namespace Sastrawi\SentenceDetector\Dictionary;

/**
 * Implementation of the DictionaryInterface using Array
 */
class ArrayDictionary implements DictionaryInterface
{
    /**
     * @var string[]
     */
    protected $words = array();

    public function __construct(array $words = array())
    {
        $this->addWords($words);
    }

    /**
     * {@inheritdoc}
     */
    public function contains($word)
    {
        return isset($this->words[$word]);
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return count($this->words);
    }

    /**
     * Add multiple words to the dictionary
     *
     * @param  array $words
     * @return void
     */
    public function addWords(array $words)
    {
        foreach ($words as $word) {
            $this->add($word);
        }
    }

    /**
     * Add a word to the dictionary
     *
     * @param  string $word
     * @return void
     */
    public function add($word)
    {
        if ($word === '') {
            return;
        }

        $this->words[$word] = $word;
    }
}
