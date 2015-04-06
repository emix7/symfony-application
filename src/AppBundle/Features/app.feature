Feature: Show home page
  In order to provide entry to my website
  users should be able to
  visit the home page

  Scenario: Show home page
    Given I am on the homepage
    Then the response status code should be 200
    Then I should see a "title" element
