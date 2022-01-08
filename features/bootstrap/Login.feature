@Login
Feature: Login
  Background: login
    Given I am on the homepage
    And I should see "Log in"

  @Smoke-testing
  Scenario: Verify Login
    When I follow "Log in"
    And I fill in "Email" with "tarun77@gmail.com"
    When I fill in "Password" with "tarun@123"
    And I press "Log in"
    Then I should see "Login was unsuccessful. Please correct the errors and try again."
    Then the "Email" field should contain "tarun77@gmail.com"
    Then the "Password" field should not contain "tarun@123"

  @sanity
  Scenario: Verify Forget Password
    When I follow "Log in"
    Then I follow "Forgot password?"

