Feature: WSSE Authentication mechanism
  In order to demonstrate the authentication
  mechanism works, users should be able to
  retrieve an access token and access the
  secured area.

  Scenario: Call with invalid API key
    Given I am an API user
    And I have an invalid API key
    When I go to "/api/articles.json"
    Then the response status code should be 401

  Scenario: Call with valid API key
    Given I am an API user
    And I have a valid API key
    When I set the authorization header
    And I go to "/api/articles.json"
    Then the response status code should be 200
    And the response should contain "slug"
