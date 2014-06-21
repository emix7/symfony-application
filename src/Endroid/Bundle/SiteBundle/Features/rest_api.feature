Feature: Perform a secure API call
  In order to demonstrate the authentication
  mechanism works, users should be able to
  perform an API call

  Scenario: Perform API call
    Given I create a client id and secret
    Given I retrieve an access token
    Then I should be able to perform an API call
