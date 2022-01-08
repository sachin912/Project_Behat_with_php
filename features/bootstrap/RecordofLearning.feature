Feature: Record of learning
  Background: Login and open homepage
    Given I am on homepage
    And I fill in "username" with "testingxperts"
    And I fill in "password" with "Test@123"
    Then I press "Log in"
    When I follow "Learn"
    Then I follow "Record of Learning"
    And I wait 5 seconds
   @kineoRecordOfLearningt1
   Scenario: Record of learning default course tab
   When I should see Required components
   @rolt2
   Scenario: Record of learning Show/Hide
     When I should see a "#show-showhide-dialog" element
     Then I press "Show/Hide Columns"
     Then I should see Required components for ShoworHide
  @RolEditReport
  Scenario: Record of learning Edit Report
     When I press "Edit this report"
     Then I should see "Edit Report 'Record of Learning: Courses' ("
     And I should see current url "https://testingxperts.thirteen.demo.kineoplatforms.net/totara/reportbuilder/general.php?id=67"
  @RolActions
  Scenario: Record of learning Actions button
    When I follow "Home"
    Then I press "Manage dashboards"
    And I follow "Your dashboard"
    Then I press "Blocks editing on"
    And I click on element "//*[contains(@class,'record_of_learning')]//*[@class='toggle-display ']" with xpath
    When I should see Required components for Popup



