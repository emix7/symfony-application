Feature: Show home page
  In order to provide entry to my website
  users should be able to
  visit the home page

  Scenario: Show home page
    Given I am on "/"
    And print last response
    Then I should see "Symfony Application" in the "h1" element