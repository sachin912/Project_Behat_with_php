#This is sample comment
@Search
Feature: Search
  In order to filter the content
  User should be able to
  to search on the website

  @sanity
  Scenario: Search for a word that does not exist
    Given I am on the homepage
    When I fill in "small-searchterms" with "iphone"
    And I press "Search"
    Then I should see "No products were found that matched your criteria."

  @smoke
  Scenario Outline: Search for a product
    Given I am on the homepage
    When I fill in "small-searchterms" with "<term>"
    And I press "Search"
    Then I should see "<result>"
    Examples:
      | term    | result              |
      | Samsung | No products were found that matched your criteria.|
      | XBox    | Medal of Honor - Limited Edition (Xbox 360) |
  @Sample
  Scenario: my small sample
    Given I am on the homepage
    Then i read attributes