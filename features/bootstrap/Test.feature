@Verify_Auto-Enrol_Download @tag_scenario @BUG:7654 @tag_ignore
Feature: AUTO ENROLL

  Background:  Verify login is success after input correct login credential.
    Given I am on the homepage
    And I fill in "username" with "testingxperts"
    And I fill in "password" with "Test@123"
    Then I press "Log in"
    Then I should see "Home"
  @tag_feature @severity:blocker @JIRA:PROD-4444
  Scenario: Verify the User should be able to submit the assignment

#  @Description : fork
#    And I onClick "xpath" and "(//a//span[text()='AutoEnrol'])[1]"
    Then I wait 5 seconds
#    And Switch User
#    Then Create New Assignment and Enroll to the Learner