@contactus
Feature: As an Ecommerce store owner,
  I want customer are able to contact me in case of any query
  Background: Click on contact us
  Given I am on the homepage
  And I follow "Contact us"
  @usingpysting
  Scenario: Fill in Contact Us form
    When I fill in "email" with "goswami.tarun77@gmail.com"
    When I fill in "FullName" with "Sachin"
    And I fill in "Enquiry" with:
      """
      Dear,

      Its been more than a week, I have not received my order.

      Thanks,
      Sachin
      """
    Then I wait "10" seconds

  @usingtable
  Scenario: Verify Registration Functionality
    When I enter following details
      | Your name     | Your email |
      | Tarun Goswami | goswami.tarun77@gmail.com|
