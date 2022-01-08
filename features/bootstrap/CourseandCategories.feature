  Feature: Courses and Categories
  Background: Login and open homepage
    Given I am on homepage
    And I fill in "username" with "testingxperts"
    And I fill in "password" with "Test@123"
    Then I press "Log in"
  @Kineo_TC-077
    Scenario: Courses and categories
    When I click on element "#quickaccess-popover-container" with cssSelector
    And I follow "Courses and categories"
    And I follow "Auto enrol"
    Then I click on the element "//*[@class='course-detail'] //*[contains(text(),'View')]" with xpath
    Then I press "Turn editing on"
    And Click on Add an activity and assginment
    And I follow "enrol"
    Then I should see "test"
    Then I delete assignment
    Then I click on the element "//*[@role='treeitem'] //*[contains(text(),'Users')]" with xpath
    And I follow "Enrolled users"
    And verify and Enrol user
#    Then I click on the element "(//*[@value='Enrol users']) [1]" with xpath
#    Then fill in "enrolusersearch" with "gslearner4"
#    And I press "searchbtn"
#    Then I wait "5" seconds
#    Then I click on the element "//*[@value='Enrol'] [1]" with xpath
#    And I press "Finish enrolling users"
    Then I reload the page
    When I should see "GS Learner4" in locator with xpath "//*[contains(@class,'userfullnamedisplay')]"
    And I click on element "span[title='Unenrol GS Learner4']" with cssSelector
    Then I press "Continue"







