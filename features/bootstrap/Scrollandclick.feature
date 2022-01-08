@login1
Feature:Verify scroll functionality

  Background:
    Given I am on homepage
   And I press x button

  @scroll
  Scenario: fill
    When I fill in "EMAIL" with "goswami.tarun77@gmail.com"
    And I click on subscribe button