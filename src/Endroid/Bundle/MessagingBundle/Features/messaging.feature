Feature: Send RabbitMQ message
  In order to demonstrate messaging via RabbitMQ
  users should be able to produce a message
  and verify the message was consumed

  Scenario: Send RabbitMQ message
    Given I am on "/messaging"
    Then the response status code should be 200
    Then I should find a file "message.json" in the cache folder