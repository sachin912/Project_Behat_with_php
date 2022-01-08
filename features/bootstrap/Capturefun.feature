Feature: Optional non optional capturing concept
  @optional
  Scenario:Optional concept
   #Positive
  Then I see "test" link
    #Negative
  Then I do not see "test me" link

  @nonoptional
    Scenario: Non Optional
    When I follow "test" link
    When He follows "test" link
    When User follow "test" link
    When She follows "test" link
    When I select 2nd item
    When I select 11th item
    When I select 21st item
