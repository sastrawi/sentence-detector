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
 * Email Address Analyzer
 *
 * @author Andy Librian
 */
class EmailAddress implements AnalyzerInterface
{
    /**
     * {@inheritdoc}
     */
    public function shouldSplit(Model $model)
    {
        $token    = $this->getToken($model->getText(), $model->getPosition());
        if ($token !== '' && filter_var($token, FILTER_VALIDATE_EMAIL)) {
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
            $tokenEnd   = (($nextWs === false) ? strlen($text) : $nextWs) - 1;

            $token = substr($text, $tokenStart, $tokenEnd - $tokenStart);

            return $token;
        } else {
            return '';
        }
    }
}
