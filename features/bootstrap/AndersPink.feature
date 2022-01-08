@anderpink
Feature: AndersPink
  Background: Login and open homepage
    Given I am on homepage
    And I fill in "username" with "testingxperts"
    And I fill in "password" with "Test@123"
    Then I press "Log in"
#    @t1
#  Scenario: AndersPink First
#    When i read the attributes and verify the tittle
#    And I click on link
#    Then I switch to next windows
#    And I should see "Mavrck raises $120M to scale its influencer marketing platform"
#    Then I should be on "https://techcrunch.com/2021/12/16/mavrck-raises-120m-to-scale-its-influencer-marketing-platform/"
    @t2
    Scenario: Anderspink first
      When I click on link
      Then I switch to previous windows
      Then i read the attributes and verify the tittle
     @t4
     Scenario: Manage Dashboard
       Then I click on ManageDashboard
       Then I wait 5 seconds
    @t3
    Scenario: Click on every link
      When I click on every link and verify title

