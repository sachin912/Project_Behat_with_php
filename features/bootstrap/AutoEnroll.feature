Feature: AutoEnroll
  Background: Login and open homepage
    Given I am on homepage
    And I fill in "username" with "testingxperts"
    And I fill in "password" with "Test@123"
    Then I press "Log in"
    @AddAutoEnrollCourses
#      When I click on element "#quickaccess-popover-container" with cssSelector
#      And I follow "Courses and categories"
#      Then I follow "Create new course"
#      And I fill in "id_fullname" with "testingxpertsnewfull"
#      And I fill in "id_shortname" with "testingxpertsnewshort"
#      Then I click on element "#id_saveanddisplay" with cssSelector
#      And I wait "3" seconds
      Scenario: AutoEnroll functionality
      When I click on auto enroll course
      Then I press "Turn editing on"
      And Click on Add an activity and assginment
      When I follow "AutoEnrol"
      Then I should see "test"
      And I switch to gslearner
      When I click on auto enroll course
      Then I should see "test"
      When I switch to Admin
      When I click on auto enroll course
      And I press "Turn editing on"
      Then I delete assignment
      @Kineo_TC-077
      Scenario: AutoEnrol functionality
        When

      