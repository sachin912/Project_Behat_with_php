Feature: Required learning block
  Background: Login and open homepage
    Given I am on homepage
    And I fill in "username" with "testingxperts"
    And I fill in "password" with "Test@123"
    Then I press "Log in"
    Then I press "Manage dashboards"
    And I follow "Your dashboard"
    Then I press "Blocks editing on"
  @GoTORequiredLearning
  Scenario:Go Required Learning
    When I check if Required Learning exist then click on "Go to Required Learning" else create and click
    Then I should see "Required Learning"
    And I should see current url "https://testingxperts.thirteen.demo.kineoplatforms.net/totara/program/required.php?userid=4064"
  @ComplianceRequiredLearning
  Scenario:Compliance for People Leaders Required Learning
    When I check if Required Learning exist then click on "[title='Compliance for People Leaders']" else create and click
    Then I should see "Compliance for People Leaders"
    And I should see current url "https://testingxperts.thirteen.demo.kineoplatforms.net/totara/program/view.php?id=10"
  @RequiredLearningDeletion
  Scenario: Required Learning block Deletion
    Then I verify the Required Learning Deletion Task