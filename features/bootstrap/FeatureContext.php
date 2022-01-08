<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\MinkContext;

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends MinkContext implements Context
{
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
    }
//    /**
//     * @Then I wait :arg1 seconds
//     */
//    public function iWaitSeconds($arg1)
//    {
//        sleep($arg1);
//        //throw new PendingException();
//    }
//    /**
//     * @BeforeScenario
//     */
//    public function before($event)
//    {
//        $this->visitPath('/');
//       // $this->getSession()->maximizeWindow();
//      // $this->getSession()->resizeWindow(1500, 500);
//
//    }
}