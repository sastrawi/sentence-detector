<?php
/**
 * Sastrawi Sentence Detector (https://github.com/sastrawi/sentence-detector)
 *
 * @link      http://github.com/sastrawi/sentence-detector for the canonical source repository
 * @license   https://github.com/sastrawi/sentence-detector/blob/master/LICENSE The MIT License (MIT)
 */

namespace Sastrawi\SentenceDetector\EosAnalyzer;

use Sastrawi\SentenceDetector\Util\StringUtil;

/**
 * Analyze wether an end of sentence character is a part of TLD (Top Level Domain)
 *
 * @author Andy Librian
 */
class Tld implements AnalyzerInterface
{
    private $tlds = array();

    private $eosChars;

    public function __construct(array $tlds = array())
    {
        $this->tlds = $tlds;
        $this->eosChars = StringUtil::getStandardEosChars();
    }

    /**
     * {@inheritdoc}
     */
    public function shouldSplit(Model $model)
    {
        $token    = $this->getToken($model->getText(), $model->getPosition());
        if ($token !== '' && $this->isValidTld($token)) {
            return false;
        }

        return true;
    }

    private function getToken($text, $position)
    {
        if ($position < (strlen($text) - 1) && !StringUtil::isWhitespace(substr($text, $position + 1, 1))) {
            $nextWs = StringUtil::getNextWhitespace($text, $position);
            $prevWs = StringUtil::getPrevWhitespace($text, $position);

            $tokenStart = ($prevWs === false) ? 0 : $prevWs + 1;
            $tokenEnd   = (($nextWs === false) ? strlen($text) : $nextWs);

            $token = substr($text, $tokenStart, $tokenEnd - $tokenStart);

            // strip trailing .
            if (!empty($token) && in_array($token[strlen($token) - 1], $this->eosChars)) {
                $token = substr($token, 0, strlen($token) - 1);
            }

            return $token;
        } else {
            return '';
        }
    }

    private function isValidTld($string)
    {
        $urlParts = parse_url($string);

        if (empty($urlParts)) {
            return false;
        }

        $path = $urlParts['path'];
        foreach ($this->tlds as $tld) {
            if (preg_match("/\\$tld$/", $path) || preg_match("/\\$tld([\\/\\#\\.])/", $path)) {
                return true;
            }
        }

        return false;
    }
}
