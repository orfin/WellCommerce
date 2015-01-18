@attribute
Feature: Manage attributes
  In order to manage attributes
  As a administrator
  I should be able to manage attribute groups and their attributes

  Background:
    Given I am logged as an administrator

  Scenario: List availability groups
    Given I am on the index page
    Then I should see "Attribute groups"