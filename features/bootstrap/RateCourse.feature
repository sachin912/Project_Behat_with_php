Feature: Ratecourse
  Background: Login and open homepage
    Given I am on homepage
    And I fill in "username" with "testingxperts"
    And I fill in "password" with "Test@123"
    Then I press "Log in"
  @Kineo_TC-112
  Scenario: Recommend course
    When I click on element "#quickaccess-popover-container" with cssSelector
    And I follow "Courses and categories"
    Then I click on the element "//*[@class='category-listing']//li[@class='listitem listitem-category']//*[contains(text(),'TXDemo')]" with xpath
    And I follow "Create new course"
    Then Fill the Course Data
    When I press "Save and display"
    Then I click on the element "//*[@role='treeitem'] //*[contains(text(),'Users')]" with xpath
    And I follow "Enrolled users"
    Then I wait 3 seconds
    When Enrol Admin user
    And I refresh the page
    Then verify and Enrol user
    And I follow "Home"
    Then I wait 3 seconds
    Then I open new created course
    And I scroll and click the course
    Then I wait 3 seconds
    And I press "Turn editing on"
    Then I wait 3 seconds
    Then I check if Rate Course exist then click on "#btn-review-recommend" else create and click on recommend
    And I follow "Search for a user"
    Then I fill in "s2id_autogen2_search" with "GS Learner4"
    Then I wait 3 seconds
    And I click on element "div[id*=result-label]" with cssSelector
    Then I click on the element "//button[contains(text(),'Recommend course')]" with xpath
    And I switch to gslearner
    Then I verify the recommended course name
    Then I click on the element "(//*[@title='Dismiss recommendation'])[1]" with xpath
    And I switch to Admin
    When I click on element "#quickaccess-popover-container" with cssSelector
    And I follow "Courses and categories"
    Then I click on the element "//*[@class='category-listing']//li[@class='listitem listitem-category']//*[contains(text(),'TXDemo')]" with xpath
    Then I wait 2 seconds
    And Delete the Course



