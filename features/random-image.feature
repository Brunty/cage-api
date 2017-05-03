Feature: Requesting a random image returns an image in the requested format

  Scenario: I can get a random image
    When I go to "/random"
    Then the response status code should be 200
