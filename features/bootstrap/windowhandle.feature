@frame
Feature:WindowHandle browser
  Background: goto homepage
    Given I am on homepage
  @switchwindows
  Scenario: Work with multiple frames
  When I follow "Facebook"
    Then I wait "10" seconds
  Then I switch to next windows
 @browser
 Scenario: verify browser
   When I follow "Sitemap"
   Then I wait "2" seconds
   Then I should see "Manufacturers"
   And I should see "Categories"
   And I refresh the page
   Then I wait "5" seconds
   When I press browser back button
   Then I wait "5" seconds
   Then I should see "Welcome to our store"
   When I press browser forward button
   Then I wait "5" seconds
   Then I should see "Sitemap"
   And I should see "Categories"
