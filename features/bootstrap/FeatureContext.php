<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Sastrawi\SentenceDetector\SentenceDetectorFactory;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context, SnippetAcceptingContext
{
    private $text;
    
    private $sentenceDetector;
    
    private $sentences = array();
    
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
        $sentenceDetectorFactory = new SentenceDetectorFactory();
        $this->sentenceDetector  = $sentenceDetectorFactory->createSentenceDetector();
    }

    /**
     * @Given The following text:
     */
    public function theFollowingText(PyStringNode $string)
    {
        $this->text = (string)$string;
    }

    /**
     * @When I detect its sentences
     */
    public function iDetectItsSentences()
    {
        $this->sentences = $this->sentenceDetector->detect($this->text);
    }

    /**
     * @Then I should get the following sentences:
     */
    public function iShouldGetTheFollowingSentences(PyStringNode $string)
    {
        $text = (string)$string;
        $sentences = explode("\n", $text);

        \PHPUnit_Framework_Assert::assertEquals($sentences, $this->sentences);
    }
}
