<?php

/*
 * This file is part of the Behat MinkExtension.
 * (c) Konstantin Kudryashov <ever.zet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Behat\MinkExtension\Context;

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\TranslatableContext;
use Behat\Gherkin\Node\TableNode;
use Cassandra\Function_;

/**
 * Mink context for Behat BDD tool.
 * Provides Mink integration and base step definitions.
 *
 * @author Konstantin Kudryashov <ever.zet@gmail.com>
 */
class MinkContext extends RawMinkContext implements TranslatableContext
{ public  $num=1;
    public $check;
    /**
     * Opens homepage
     * Example: Given I am on "/"
     * Example: When I go to "/"
     * Example: And I go to "/"
     *
     * @Given /^(?:|I )am on (?:|the )homepage$/
     * @When /^(?:|I )go to (?:|the )homepage$/
     */
    public function iAmOnHomepage()
    {
        $this->visitPath('/');
    }

    /**
     * Opens specified page
     * Example: Given I am on "http://batman.com"
     * Example: And I am on "/articles/isBatmanBruceWayne"
     * Example: When I go to "/articles/isBatmanBruceWayne"
     *
     * @Given /^(?:|I )am on "(?P<page>[^"]+)"$/
     * @When /^(?:|I )go to "(?P<page>[^"]+)"$/
     */
    public function visit($page)
    {
        $this->visitPath($page);
    }

    /**
     * Reloads current page
     * Example: When I reload the page
     * Example: And I reload the page
     *
     * @When /^(?:|I )reload the page$/
     */
    public function reload()
    {
        $this->getSession()->reload();
    }

    /**
     * Moves backward one page in history
     * Example: When I move backward one page
     *
     * @When /^(?:|I )move backward one page$/
     */
    public function back()
    {
        $this->getSession()->back();
    }

    /**
     * Moves forward one page in history
     * Example: And I move forward one page
     *
     * @When /^(?:|I )move forward one page$/
     */
    public function forward()
    {
        $this->getSession()->forward();
    }

    /**
     * Presses button with specified id|name|title|alt|value
     * Example: When I press "Log In"
     * Example: And I press "Log In"
     *
     * @When /^(?:|I )press "(?P<button>(?:[^"]|\\")*)"$/
     */
    public function pressButton($button)
    {
        $button = $this->fixStepArgument($button);
        $this->getSession()->getPage()->pressButton($button);
    }

    /**
     * Clicks link with specified id|title|alt|text
     * Example: When I follow "Log In"
     * Example: And I follow "Log In"
     *
     * @When /^(?:|I )follow "(?P<link>(?:[^"]|\\")*)"$/
     */
    public function clickLink($link)
    {
        $link = $this->fixStepArgument($link);
        $this->getSession()->getPage()->clickLink($link);
    }

    /**
     * Fills in form field with specified id|name|label|value
     * Example: When I fill in "username" with: "bwayne"
     * Example: And I fill in "bwayne" for "username"
     *
     * @When /^(?:|I )fill in "(?P<field>(?:[^"]|\\")*)" with "(?P<value>(?:[^"]|\\")*)"$/
     * @When /^(?:|I )fill in "(?P<field>(?:[^"]|\\")*)" with:$/
     * @When /^(?:|I )fill in "(?P<value>(?:[^"]|\\")*)" for "(?P<field>(?:[^"]|\\")*)"$/
     */
    public function fillField($field, $value)
    {
        $field = $this->fixStepArgument($field);
        $value = $this->fixStepArgument($value);
        $this->getSession()->getPage()->fillField($field, $value);
    }

    /**
     * Fills in form fields with provided table
     * Example: When I fill in the following"
     *              | username | bruceWayne |
     *              | password | iLoveBats123 |
     * Example: And I fill in the following"
     *              | username | bruceWayne |
     *              | password | iLoveBats123 |
     *
     * @When /^(?:|I )fill in the following:$/
     */
    public function fillFields(TableNode $fields)
    {
        foreach ($fields->getRowsHash() as $field => $value) {
            $this->fillField($field, $value);
        }
    }

    /**
     * Selects option in select field with specified id|name|label|value
     * Example: When I select "Bats" from "user_fears"
     * Example: And I select "Bats" from "user_fears"
     *
     * @When /^(?:|I )select "(?P<option>(?:[^"]|\\")*)" from "(?P<select>(?:[^"]|\\")*)"$/
     */
    public function selectOption($select, $option)
    {
        $select = $this->fixStepArgument($select);
        $option = $this->fixStepArgument($option);
        $this->getSession()->getPage()->selectFieldOption($select, $option);
    }

    /**
     * Selects additional option in select field with specified id|name|label|value
     * Example: When I additionally select "Deceased" from "parents_alive_status"
     * Example: And I additionally select "Deceased" from "parents_alive_status"
     *
     * @When /^(?:|I )additionally select "(?P<option>(?:[^"]|\\")*)" from "(?P<select>(?:[^"]|\\")*)"$/
     */
    public function additionallySelectOption($select, $option)
    {
        $select = $this->fixStepArgument($select);
        $option = $this->fixStepArgument($option);
        $this->getSession()->getPage()->selectFieldOption($select, $option, true);
    }

    /**
     * Checks checkbox with specified id|name|label|value
     * Example: When I check "Pearl Necklace"
     * Example: And I check "Pearl Necklace"
     *
     * @When /^(?:|I )check "(?P<option>(?:[^"]|\\")*)"$/
     */
    public function checkOption($option)
    {
        $option = $this->fixStepArgument($option);
        $this->getSession()->getPage()->checkField($option);
    }

    /**
     * Unchecks checkbox with specified id|name|label|value
     * Example: When I uncheck "Broadway Plays"
     * Example: And I uncheck "Broadway Plays"
     *
     * @When /^(?:|I )uncheck "(?P<option>(?:[^"]|\\")*)"$/
     */
    public function uncheckOption($option)
    {
        $option = $this->fixStepArgument($option);
        $this->getSession()->getPage()->uncheckField($option);
    }

    /**
     * Attaches file to field with specified id|name|label|value
     * Example: When I attach "bwayne_profile.png" to "profileImageUpload"
     * Example: And I attach "bwayne_profile.png" to "profileImageUpload"
     *
     * @When /^(?:|I )attach the file "(?P<path>[^"]*)" to "(?P<field>(?:[^"]|\\")*)"$/
     */
    public function attachFileToField($field, $path)
    {
        $field = $this->fixStepArgument($field);

        if ($this->getMinkParameter('files_path')) {
            $fullPath = rtrim(realpath($this->getMinkParameter('files_path')), DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR.$path;
            if (is_file($fullPath)) {
                $path = $fullPath;
            }
        }

        $this->getSession()->getPage()->attachFileToField($field, $path);
    }

    /**
     * Checks, that current page PATH is equal to specified
     * Example: Then I should be on "/"
     * Example: And I should be on "/bats"
     * Example: And I should be on "http://google.com"
     *
     * @Then /^(?:|I )should be on "(?P<page>[^"]+)"$/
     */
    public function assertPageAddress($page)
    {
        $this->assertSession()->addressEquals($this->locatePath($page));
    }

    /**
     * Checks, that current page is the homepage
     * Example: Then I should be on the homepage
     * Example: And I should be on the homepage
     *
     * @Then /^(?:|I )should be on (?:|the )homepage$/
     */
    public function assertHomepage()
    {
        $this->assertSession()->addressEquals($this->locatePath('/'));
    }

    /**
     * Checks, that current page PATH matches regular expression
     * Example: Then the url should match "superman is dead"
     * Example: Then the uri should match "log in"
     * Example: And the url should match "log in"
     *
     * @Then /^the (?i)url(?-i) should match (?P<pattern>"(?:[^"]|\\")*")$/
     */
    public function assertUrlRegExp($pattern)
    {
        $this->assertSession()->addressMatches($this->fixStepArgument($pattern));
    }

    /**
     * Checks, that current page response status is equal to specified
     * Example: Then the response status code should be 200
     * Example: And the response status code should be 400
     *
     * @Then /^the response status code should be (?P<code>\d+)$/
     */
    public function assertResponseStatus($code)
    {
        $this->assertSession()->statusCodeEquals($code);
    }

    /**
     * Checks, that current page response status is not equal to specified
     * Example: Then the response status code should not be 501
     * Example: And the response status code should not be 404
     *
     * @Then /^the response status code should not be (?P<code>\d+)$/
     */
    public function assertResponseStatusIsNot($code)
    {
        $this->assertSession()->statusCodeNotEquals($code);
    }

    /**
     * Checks, that page contains specified text
     * Example: Then I should see "Who is the Batman?"
     * Example: And I should see "Who is the Batman?"
     *
     * @Then /^(?:|I )should see "(?P<text>(?:[^"]|\\")*)"$/
     */
    public function assertPageContainsText($text)
    {
        $this->assertSession()->pageTextContains($this->fixStepArgument($text));
    }

    /**
     * Checks, that page doesn't contain specified text
     * Example: Then I should not see "Batman is Bruce Wayne"
     * Example: And I should not see "Batman is Bruce Wayne"
     *
     * @Then /^(?:|I )should not see "(?P<text>(?:[^"]|\\")*)"$/
     */
    public function assertPageNotContainsText($text)
    {
        $this->assertSession()->pageTextNotContains($this->fixStepArgument($text));
    }

    /**
     * Checks, that page contains text matching specified pattern
     * Example: Then I should see text matching "Batman, the vigilante"
     * Example: And I should not see "Batman, the vigilante"
     *
     * @Then /^(?:|I )should see text matching (?P<pattern>"(?:[^"]|\\")*")$/
     */
    public function assertPageMatchesText($pattern)
    {
        $this->assertSession()->pageTextMatches($this->fixStepArgument($pattern));
    }

    /**
     * Checks, that page doesn't contain text matching specified pattern
     * Example: Then I should see text matching "Bruce Wayne, the vigilante"
     * Example: And I should not see "Bruce Wayne, the vigilante"
     *
     * @Then /^(?:|I )should not see text matching (?P<pattern>"(?:[^"]|\\")*")$/
     */
    public function assertPageNotMatchesText($pattern)
    {
        $this->assertSession()->pageTextNotMatches($this->fixStepArgument($pattern));
    }

    /**
     * Checks, that HTML response contains specified string
     * Example: Then the response should contain "Batman is the hero Gotham deserves."
     * Example: And the response should contain "Batman is the hero Gotham deserves."
     *
     * @Then /^the response should contain "(?P<text>(?:[^"]|\\")*)"$/
     */
    public function assertResponseContains($text)
    {
        $this->assertSession()->responseContains($this->fixStepArgument($text));
    }

    /**
     * Checks, that HTML response doesn't contain specified string
     * Example: Then the response should not contain "Bruce Wayne is a billionaire, play-boy, vigilante."
     * Example: And the response should not contain "Bruce Wayne is a billionaire, play-boy, vigilante."
     *
     * @Then /^the response should not contain "(?P<text>(?:[^"]|\\")*)"$/
     */
    public function assertResponseNotContains($text)
    {
        $this->assertSession()->responseNotContains($this->fixStepArgument($text));
    }

    /**
     * Checks, that element with specified CSS contains specified text
     * Example: Then I should see "Batman" in the "heroes_list" element
     * Example: And I should see "Batman" in the "heroes_list" element
     *
     * @Then /^(?:|I )should see "(?P<text>(?:[^"]|\\")*)" in the "(?P<element>[^"]*)" element$/
     */
    public function assertElementContainsText($element, $text)
    {
        $this->assertSession()->elementTextContains('css', $element, $this->fixStepArgument($text));
    }

    /**
     * Checks, that element with specified CSS doesn't contain specified text
     * Example: Then I should not see "Bruce Wayne" in the "heroes_alter_egos" element
     * Example: And I should not see "Bruce Wayne" in the "heroes_alter_egos" element
     *
     * @Then /^(?:|I )should not see "(?P<text>(?:[^"]|\\")*)" in the "(?P<element>[^"]*)" element$/
     */
    public function assertElementNotContainsText($element, $text)
    {
        $this->assertSession()->elementTextNotContains('css', $element, $this->fixStepArgument($text));
    }

    /**
     * Checks, that element with specified CSS contains specified HTML
     * Example: Then the "body" element should contain "style=\"color:black;\""
     * Example: And the "body" element should contain "style=\"color:black;\""
     *
     * @Then /^the "(?P<element>[^"]*)" element should contain "(?P<value>(?:[^"]|\\")*)"$/
     */
    public function assertElementContains($element, $value)
    {
        $this->assertSession()->elementContains('css', $element, $this->fixStepArgument($value));
    }

    /**
     * Checks, that element with specified CSS doesn't contain specified HTML
     * Example: Then the "body" element should not contain "style=\"color:black;\""
     * Example: And the "body" element should not contain "style=\"color:black;\""
     *
     * @Then /^the "(?P<element>[^"]*)" element should not contain "(?P<value>(?:[^"]|\\")*)"$/
     */
    public function assertElementNotContains($element, $value)
    {
        $this->assertSession()->elementNotContains('css', $element, $this->fixStepArgument($value));
    }

    /**
     * Checks, that element with specified CSS exists on page
     * Example: Then I should see a "body" element
     * Example: And I should see a "body" element
     *
     * @Then /^(?:|I )should see an? "(?P<element>[^"]*)" element$/
     */
    public function assertElementOnPage($element)
    {
        $this->assertSession()->elementExists('css', $element);
    }

    /**
     * Checks, that element with specified CSS doesn't exist on page
     * Example: Then I should not see a "canvas" element
     * Example: And I should not see a "canvas" element
     *
     * @Then /^(?:|I )should not see an? "(?P<element>[^"]*)" element$/
     */
    public function assertElementNotOnPage($element)
    {
        $this->assertSession()->elementNotExists('css', $element);
    }

    /**
     * Checks, that form field with specified id|name|label|value has specified value
     * Example: Then the "username" field should contain "bwayne"
     * Example: And the "username" field should contain "bwayne"
     *
     * @Then /^the "(?P<field>(?:[^"]|\\")*)" field should contain "(?P<value>(?:[^"]|\\")*)"$/
     */
    public function assertFieldContains($field, $value)
    {
        $field = $this->fixStepArgument($field);
        $value = $this->fixStepArgument($value);
        $this->assertSession()->fieldValueEquals($field, $value);
    }

    /**
     * Checks, that form field with specified id|name|label|value doesn't have specified value
     * Example: Then the "username" field should not contain "batman"
     * Example: And the "username" field should not contain "batman"
     *
     * @Then /^the "(?P<field>(?:[^"]|\\")*)" field should not contain "(?P<value>(?:[^"]|\\")*)"$/
     */
    public function assertFieldNotContains($field, $value)
    {
        $field = $this->fixStepArgument($field);
        $value = $this->fixStepArgument($value);
        $this->assertSession()->fieldValueNotEquals($field, $value);
    }

    /**
     * Checks, that (?P<num>\d+) CSS elements exist on the page
     * Example: Then I should see 5 "div" elements
     * Example: And I should see 5 "div" elements
     *
     * @Then /^(?:|I )should see (?P<num>\d+) "(?P<element>[^"]*)" elements?$/
     */
    public function assertNumElements($num, $element)
    {
        $this->assertSession()->elementsCount('css', $element, intval($num));
    }

    /**
     * Checks, that checkbox with specified id|name|label|value is checked
     * Example: Then the "remember_me" checkbox should be checked
     * Example: And the "remember_me" checkbox is checked
     *
     * @Then /^the "(?P<checkbox>(?:[^"]|\\")*)" checkbox should be checked$/
     * @Then /^the "(?P<checkbox>(?:[^"]|\\")*)" checkbox is checked$/
     * @Then /^the checkbox "(?P<checkbox>(?:[^"]|\\")*)" (?:is|should be) checked$/
     */
    public function assertCheckboxChecked($checkbox)
    {
        $this->assertSession()->checkboxChecked($this->fixStepArgument($checkbox));
    }

    /**
     * Checks, that checkbox with specified id|name|label|value is unchecked
     * Example: Then the "newsletter" checkbox should be unchecked
     * Example: Then the "newsletter" checkbox should not be checked
     * Example: And the "newsletter" checkbox is unchecked
     *
     * @Then /^the "(?P<checkbox>(?:[^"]|\\")*)" checkbox should (?:be unchecked|not be checked)$/
     * @Then /^the "(?P<checkbox>(?:[^"]|\\")*)" checkbox is (?:unchecked|not checked)$/
     * @Then /^the checkbox "(?P<checkbox>(?:[^"]|\\")*)" should (?:be unchecked|not be checked)$/
     * @Then /^the checkbox "(?P<checkbox>(?:[^"]|\\")*)" is (?:unchecked|not checked)$/
     */
    public function assertCheckboxNotChecked($checkbox)
    {
        $this->assertSession()->checkboxNotChecked($this->fixStepArgument($checkbox));
    }

    /**
     * Prints current URL to console.
     * Example: Then print current URL
     * Example: And print current URL
     *
     * @Then /^print current URL$/
     */
    public function printCurrentUrl()
    {
        echo $this->getSession()->getCurrentUrl();
    }

    /**
     * Prints last response to console
     * Example: Then print last response
     * Example: And print last response
     *
     * @Then /^print last response$/
     */
    public function printLastResponse()
    {
        echo (
            $this->getSession()->getCurrentUrl()."\n\n".
            $this->getSession()->getPage()->getContent()
        );
    }

    /**
     * Opens last response content in browser
     * Example: Then show last response
     * Example: And show last response
     *
     * @Then /^show last response$/
     */
    public function showLastResponse()
    {
        if (null === $this->getMinkParameter('show_cmd')) {
            throw new \RuntimeException('Set "show_cmd" parameter in behat.yml to be able to open page in browser (ex.: "show_cmd: firefox %s")');
        }

        $filename = rtrim($this->getMinkParameter('show_tmp_dir'), DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR.uniqid().'.html';
        file_put_contents($filename, $this->getSession()->getPage()->getContent());
        system(sprintf($this->getMinkParameter('show_cmd'), escapeshellarg($filename)));
    }

    /**
     * Returns list of definition translation resources paths
     *
     * @return array
     */
    public static function getTranslationResources()
    {
        return self::getMinkTranslationResources();
    }

    /**
     * Returns list of definition translation resources paths for this dictionary
     *
     * @return array
     */
    public static function getMinkTranslationResources()
    {
        return glob(__DIR__.'/../../../../i18n/*.xliff');
    }

    /**
     * Returns fixed step argument (with \\" replaced back to ")
     *
     * @param string $argument
     *
     * @return string
     */
    protected function fixStepArgument($argument)
    {
        return str_replace('\\"', '"', $argument);
    }

    /**
     * @Then I wait :arg1 seconds
     */
    public function iWaitSeconds($arg1)
    {
        sleep($arg1);
        //throw new PendingException();
    }
    /**
     * @Then /^I (see|do not see) \"([a-zA-Z ]*)\" link$/
     */
    public function iDoNotSeeLink($option ,$arg1)
    {
        echo $option;
        echo "\n".$arg1;
//        throw new PendingException();
    }

    /**
     * @When /^(?:I|User|She|He) follow(?:s)? \"([a-zA-Z\s]*)\" link$/
     */
    public function iFollowsLink($arg1)
    {
        echo $arg1;
//        throw new PendingException();
    }

    /**
     * @When /^I select ([0-9]+)(?:nd|st|rd|th)? item$/
     */
    public function islectedNdItem($num)
    {
        echo $num;
    }
    /**
     * @BeforeSuite
     */
    public static function setup()
    {
        echo "Before Suite Executed";
    }

    /**
     * @BeforeScenario
     */
    public static function before()
    {
        echo "Before Scenario Executed";
    }

    /**
     * @BeforeStep
     */
    public static function beforeStep()
    {
        echo "Before Step Executed";
    }

    /**
     * @AfterStep
     */
    public static function afterStep()
    {
        echo "After Step Executed";
    }

    /**
     * @AfterScenario
     */
    public static function after()
    {
        echo "After Scenario Executed";
    }

    /**
     * @BeforeFeature
     */
    public static function setupFeature()
    {
        echo "Before Feature Executed";
    }

    /**
     * @AfterFeature
     */
    public static function teardownfeature()
    {
        echo "After Feature Executed";
    }

    /**
     * @AfterSuite
     */
    public static function teardown()
    {
        echo "After Suite Executed";
    }

    /**
     * @When I enter following details
     */
    public function iEnterFollowingDetails(TableNode $table)
    {
        $page = $this->getsession()->getpage();
        foreach ($table as $row)
        {
            var_dump($row);
            $name = $row['Your name'];
            $emailaddress = $row['Your email'];
            $page->find('css','.fullname')->setValue($name);
            $page->find('css','#Email')->setValue($emailaddress);
        }
    }
    /**
     * @Then /^I switch to next windows$/
     */
    public function iSwitchTonextWindows()
    {
        $windowNames = $this->getSession()->getWindowNames();

        if(count($windowNames) > 1)
        {
            $this->getSession()->switchToWindow($windowNames[1]);
            print($this->getSession()->getCurrentUrl());
        }
    }
    /**
     * @Then /^I switch to ([0-9]+)(?:nd|st|rd|th)? windows$/
     */
    public function iSwitchToxWindows($num)
    {
        $windowNames = $this->getSession()->getWindowNames();

        if(count($windowNames) > 1)
        {
            $this->getSession()->switchToWindow($windowNames[$num]);
            print($this->getSession()->getCurrentUrl());
        }
    }
    /**
     * @Then /^I switch to previous windows$/
     */
    public function iSwitchToPrevivousWindows()
    {
        $windowNames = $this->getSession()->getWindowNames();

        if(count($windowNames) > 1)
        {
            $this->getSession()->switchToWindow($windowNames[0]);
            print($this->getSession()->getCurrentUrl());
        }
    }

    /**
     * @Then I refresh the page
     */
    public function iRefreshThePage()
    {
        $this->getSession()->reload();
    }

    /**
     * @When I press browser back button
     */
    public function iPressBrowserBackButton()
    {
     $this->getSession()->back();
    }

    /**
     * @When I press browser forward button
     */
    public function iPressBrowserForwardButton()
    {
        $this->getSession()->forward();
    }

    /**
     * @Then i read attributes
     */
    public function iReadAttributes()
    {
      $page =$this->getSession()->getPage();
        $tag1 = $page->find('xpath',"//*[@data-block='anderspink']/div[2]/div[1]/a");
        $tag2 = $page->find('css','.login');
      echo "Tag1 name\n ",$tag1->getTagName();
      echo "Tag2 name \n ",$tag2->getTagName();
      echo "\nTag 1 placeholder is:" . $tag1->getAttribute('placeholder');
      echo "\nTag 2 href is:" . $tag2->getAttribute('href');
    }
    
    /**
     *@When i read the attributes and verify the tittle
     */
    public function iReadtheAttributesandVerify()
    {
      $page =$this->getSession()->getPage();
        $log1 = $page->find('xpath',"//*[@data-block='anderspink']/div[2]/div[1]/a");
        $titlevalue = $log1->getAttribute("title");
         $this->iSwitchTonextWindows();
         $this->iWaitSeconds(3);
        $this->assertPageContainsText($titlevalue);
    }

    /**
     *@Given /^I click on every link and verify title$/
     */
    public function iClickOneveryLinkAndVerifyTitle()
    {
        $page = $this->getSession()->getPage();
        $actual_rows=$page->findAll('css', '.ap-article-link');
        $actual_Values = array();
        foreach($actual_rows as $row) {
            $actual_Values[] = $row->getAttribute("title");
        }
        $countofLinks=count($actual_Values);
        $i=0;
        $j=1;
        foreach ($actual_Values as $newValue)
        {
            $actual_rows[$i]->click();
            $this->iWaitSeconds(5);
            $this->iSwitchToxWindows($j);
            echo "title is \n " .$actual_Values[$i];
            echo " current url is  \n " .$this->getSession()->getCurrentUrl();
            $this->assertPageContainsText($actual_Values[$i]);
            $this->iSwitchToxWindows(0);
            ++$i;
            ++$j;
        }
    }
    /**
     * @Given /^I click on link$/
     */
    public function iClickOnLink()
    {
        $page = $this->getSession()->getPage();
        $page->find('xpath', "//*[@data-block='anderspink']/div[2]/div[1]/a")->Click();
    }

    /**
     * @When I should see Required components
     */
    public function iShouldSeeRequiredComponents()
    {
        $array = array('Saved searches','View a saved search','Choose... ','Course Title','Search by'
        ,'Saved searches','TXDemo Course','Custom Certificate Activity','Introducing Commercial Awareness', 'AutoEnrol',
        'TestingXpertsCourse2_2');
        foreach ($array as $i)
        {
            $this->assertPageContainsText($i);
        }
    }
    /**
     * @Then I should see Required components for ShoworHide
     */
    public function iShouldSeeRequiredComponentsforShowHide()
    {
        $array = array('Type','Course Title','Previous','Completions','Course completion date', 'Progress');
        foreach ($array as $i)
        {
            $this->assertPageContainsText($i);
        }
    }
    /**
     * @Given /^I click on ManageDashboard$/
     */
    public function iClickonManageDashBoard()
    {
        $page = $this->getSession()->getPage();
        $page->find("css","[value='Manage dashboards']" )->click();
    }
    /**
     * @Then I check if Required Learning exist then click on :arg1 else create and click
     */
    public function iCheckIfRequiredLearningExistThenClickElseCreateAndClick($arg)
    {
        $page = $this->getSession()->getPage();
        if(boolval($page->find("xpath","//*[contains(@class,'block_required_learning')]")==true))
        {
            $page->find('css', $arg)->Click();
        }
        else
        {
            $page->find("xpath","//*[@id='block-region-footer-region']//*[@title='Add a block']")->Click();
           $this->iWaitSeconds(2);
           $page->find("xpath","//*[@id='block-region-footer-region']//*[@title='Add a block']")->Click();
            $page->find("xpath","//*[@id='block-region-footer-region']//*[@role='tooltip']//*[@id='addBlockPopover--search_query']")->setValue("Required Learning");
            $page->find("xpath","//*[@id='block-region-footer-region']//*[@role='tooltip'] //*[@data-addblockpopover-blocktitle='Required Learning']")->click();
            $this->iWaitSeconds(3);
            $page->find('css', $arg)->Click();
        }
    }
    /**
     * @Then I check if Rate Course exist then click on :arg1 else create and click on recommend
     */
    public function iCheckIfRateCourseExistThenClickElseCreateAndClick($arg)
    {
        $page = $this->getSession()->getPage();
        if(boolval($page->find("xpath","//div[contains(@class,'block_rate_course')]")==true))
        {
            $page->find('css', $arg)->Click();
        }
        else
        {
            $page->find("xpath","//*[@id='block-region-footer-region']//*[@title='Add a block']")->Click();
//            $this->iWaitSeconds(2);
//           $page->find("xpath","//*[@id='block-region-footer-region']//*[@title='Add a block']")->Click();
            $this->iWaitSeconds(2);
            $page->find("xpath","//*[@id='block-region-footer-region']//*[@role='tooltip']//*[@id='addBlockPopover--search_query']")->setValue("Rate Course");
            $this->iWaitSeconds(3);
            $page->find("xpath","//*[@id='block-region-footer-region']//*[@role='tooltip']//*[@data-addblockpopover-blocktitle='Rate Course']")->click();
            $this->iWaitSeconds(3);
            $page->find('css', $arg)->Click();
        }
    }
    /**
     * @Then I click on element :arg1 with xpath
     */
    public function iClickOnElementByXpath($arg)
    {
        $page = $this->getSession()->getPage();
         // if($page->hasContent("Configure Record of Learning block"))
//        echo boolval($page->find("xpath","(//*[contains(@class,'record_of_learning')]) [1]"));
        if(boolval($page->find("xpath","(//*[contains(@class,'record_of_learning')]) [1]")==true))
          {
            $page->find('xpath', $arg)->Click();
          }
         else
       {
           $page->find("xpath","//*[@id='block-region-footer-region']//*[@title='Add a block']")->Click();
//           $this->iWaitSeconds(2);
//           $page->find("xpath","//*[@id='block-region-footer-region']//*[@title='Add a block']")->Click();
           $page->find("xpath","//*[@id='block-region-footer-region']//*[@role='tooltip']//*[@id='addBlockPopover--search_query']")->setValue("Record of Learning");
           $page->find("xpath","//*[@id='block-region-footer-region']//*[@role='tooltip'] //*[@data-addblockpopover-blocktitle='Record of Learning']")->click();
           $this->iWaitSeconds(5);
           $page->find('xpath', $arg)->Click();
       }
    }

    /**
     * @When I should see Required components for Popup
     */
    public function iShouldSeeRequiredComponentsForPopup()
    {
        $array = array('Configure Record of Learning block','Permissions','Check permissions','Delete Record of Learning block');
        foreach ($array as $i)
        {
            $this->assertPageContainsText($i);
        }
        if($this->getSession()->getPage()->hasContent("Hide Record of Learning block"))
        $this->assertPageContainsText("Hide Record of Learning block");
        else
        $this->assertPageContainsText("Show Record of Learning block");
    }

    /**
     * @Given /^I click on subscribe button$/
     */
    public function iClickOnSubmitButton()
    {
        $page = $this->getSession()->getPage();
        $this->scrollAndClick("button.btn-solid");
    }
    /**
     * @Given I scroll and click with css :element
     */
    public function iscrollandclickButton($element)
    {
        $page = $this->getSession()->getPage();
        $this->scrollAndClick($element);
    }

    public function scrollAndClick($cssSelector)
    {
        $function = <<<JS
        (
            function()
            {
                document.querySelector("$cssSelector").scrollIntoView();
            }, function()
            {
                document.querySelector("$cssSelector").click();
            })() 
JS;
        try
        {
            $this->getSession()->executeScript($function);
        }
        catch (Exception $e)
        {
            throw new \Exception("Scroll Into View Failed. Check Your Script");
        }
    }
    /**
     *@When I verify the Required Learning Deletion Task
     */
    public function iVerifyTheRequiredLearningDeletionTask()
    {
        $page=$this->getSession()->getPage();
        if(boolval($page->find("xpath","(//*[contains(@class,'required_learning')]) [1]")==true))
        {
            $this-> deletionRequiredLearingCheck();
        }
        else
        {
            $this->addingTheBlock("Required Learning");
            $this->iWaitSeconds("5");
            $this->deletionRequiredLearingCheck();
        }
    }
    public function deletionRequiredLearingCheck()
    {
        $this->assertSession()->elementExists('xpath',"//*[contains(@class,'required_learning')]//*[@class='toggle-display ']");
        $this->iClickOnElementByXpath("//*[contains(@class,'required_learning')]//*[@class='toggle-display ']");
        $this->assertPageContainsText("Delete Required Learning block");
        $this->clickLink("Delete Required Learning block");
        $this->pressButton("Yes");
        $this->assertElementNotOnPage("[class*='block_required_learning']");
    }
    public function addingTheBlock($arg)
    {
        $page=$this->getSession()->getPage();
        $page->find("xpath","//*[@id='block-region-footer-region']//*[@title='Add a block']")->Click();
        $this->iWaitSeconds("2");
        $page->find("xpath","//*[@id='block-region-footer-region']//*[@title='Add a block']")->Click();
        $page->find("xpath","//*[@id='block-region-footer-region']//*[@role='tooltip']//*[@id='addBlockPopover--search_query']")->setValue($arg);
        $page->find("xpath","//*[@id='block-region-footer-region']//*[@role='tooltip'] //*[@data-addblockpopover-blocktitle='$arg']")->click();
    }

    /**
     * @Then I should see current url :arg1
     */
    public function iShouldSeeCurrentUrl($arg1)
    {
        $page = $this->getSession()->getPage();
        $this->assertPageAddress($arg1);
    }

    /**
     * @When I click on element :arg1 with cssSelector
     */
    public function iClickOnElementWithCssselector($arg1)
    {
        $page = $this->getSession()->getPage();
        $page->find("css",$arg1)->click();
    }

    /**
     *@When I should see :text in locator with xpath :element
     */
    public function assertElementContainsTextbyXpath($element, $text)
    {
        $this->assertSession()->elementTextContains('xpath', $element, $this->fixStepArgument($text));
    }

    /**
     * @Then Click on Add an activity and assginment
     */
    public function clickOnAddAnActivity()
    {
        $this->ClickOntheElementByXpath("//*[@id='section-1']//*[@class='section-modchooser-link']");
        $this->ClickOntheElementByXpath("(//*[@class='alloptions']//*[@name='jumplink'])[1]");
        $this->pressButton("Add");
        $this->fillField("id_name","test");
        $this->pressButton("Save and display");
        $value= $this->getSession()->getPage()->find('xpath',"//*[contains(@class,'gradingsummarytable')]//tr[2]//td[2]")->getText();
        $this->assertElementContainsTextbyXpath("//*[contains(@class,'gradingsummarytable')]//tr[2]//td[2]",0);
    }
    /**
     * @When I click on auto enroll course
     */
    public function iClickOnAutoEnrollCourse()
    {
        $this->ClickOntheElementByXpath("(//a//span[text()='AutoEnrol'])[1]");
    }
    /**
     * @Then I switch to Admin
     */
    public function loginUsingAdminUser()
    {
        $this->getSession()->getPage()->find("css","[class='toggle-display textmenu']")->Click();
        // $this->pressButton("#actionmenuaction-5");
        //or
        $this->ClickOntheElementByXpath("(//span[contains(text(),'Log out')])[2]");
        $this->fillField("username","testingxperts");
        $this->fillField("password","Test@123");
        $this->pressButton("Log in");
    }
    /**
     * @Then I switch to gslearner
     */
    public function loginUsingGsLearnerUser()
    {
        $this->getSession()->getPage()->find("css","#action-menu-toggle-0")->Click();
        // $this->pressButton("#actionmenuaction-5");
        //or
        $this->ClickOntheElementByXpath("(//*[contains(@id,'action-menu')])[4]//li[7]//*[contains(text(),'Log out')][2]");
        $this->fillField("username","GsLearner4");
        $this->fillField("password","Test@123");
        $this->pressButton("Log in");
    }
    /**
     * @When I click on the element :arg1 with xpath
     */
    public function ClickOntheElementByXpath($arg1)
    {
        $this->getSession()->getPage()->find("xpath", $arg1)->click();
    }
    /**
     * @Given I press x button
     */
    public function iPressXButton()
    {
     $page = $this->getSession()->getPage();
     $page->find("css",".close")->Click();
    }

    /**
     * @Then I delete assignment
     */
    public function DeleteAssignment()
    {
     $this->ClickOntheElementByXpath("//*[@data-value='test']/../following-sibling::span//b");
     $this->ClickOntheElementByXpath("//*[@data-value='test']/../following-sibling::span//a//span[contains(text(),'Delete')] [2]");
     $this->pressButton("Yes");
    }
    /**
     * @When verify and Enrol user
     */
    public function VerifyAndEnrolUser()
    {
        if($this->getSession()->getPage()->hasContent("GS Learner4"))
        {
            $this->iClickOnElementWithCssselector("span[title='Unenrol GS Learner4']");
            $this->pressButton("Continue");
        }

            $this->iWaitSeconds(5);
            $this->ClickOntheElementByXpath("(//*[@value='Enrol users']) [1]");
            $this->fillField("enrolusersearch","gslearner4");
            $this->pressButton("searchbtn");
            $this->iWaitSeconds(3);
            $this->ClickOntheElementByXpath("//*[@value='Enrol'] [1]");
            $this->pressButton("Finish enrolling users");
    }
    /**
     * @When Enrol Admin user
     */
    public function VerifyAndEnrolAdminUser()
    {

            $this->ClickOntheElementByXpath("(//*[@value='Enrol users']) [1]");
            $this->fillField("enrolusersearch","Testing Experts");
            $this->pressButton("searchbtn");
            $this->iWaitSeconds(3);
            $this->ClickOntheElementByXpath("//*[@value='Enrol'] [1]");
            $this->pressButton("Finish enrolling users");
    }
    /**
     * @Then Fill the Course Data
     */
    public  function FilltheDataName()
    {
        $this-> generatingNameAndShortName();
        $this->getSession()->getPage()->find("css", "#id_fullname")->setValue($this->check[0]);
        $this->getSession()->getPage()->find("css", "#id_shortname")->setValue($this->check[1]);

    }
    /**
     * @Then  Delete the Course
     */
    public function DeleteTheCourse()
    {
        $name=$this->check[0];
        $this->ClickOntheElementByXpath("//a[contains(text(),'$name')]/../div/following-sibling::div//a[@class='action-delete']");
        $this->iClickOnElementWithCssselector("[value='Delete']");
        $this->iClickOnElementWithCssselector("[value='Continue']");
    }/**
     * @Then I scroll and click the course
     */
    public function scrollandclickTheCourse()
    {
        $name=$this->check[0];
        $this->scrollAndClick("[title='$name']");
    } /**
     * @Then I open new created course
     */
    public function OpenTheCreatedCourse()
    {
        $name=$this->check[0];
        $this->ClickOntheElementByXpath("//a[contains(text(),'$name')]");
    }
    /**
     * @Then I verify the recommended course name
     */
    public function IverifytherecommendedCourseName()
    {
        $name=$this->check[0];
        $this->assertElementContainsTextbyXpath("(//*[@class='totaratable course-recommendations']//a[contains(text(),'$name')]) [1]","$name");
    }
    public  function generatingNameAndShortName()
    {
        if($this->num>0) {
            $courseNameGenerated = substr("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ", mt_rand(0, 50), 9);
            $courseshortNameGenerated = substr("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ", mt_rand(0, 50), 4);
            $this->check=array($courseNameGenerated,$courseNameGenerated);
            $this->num--;
        }
    }

}
