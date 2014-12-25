@availability
Feature: Manage availability statuses
  In order to manage availability statuses
  As a manager
  I should be able to see the list and add, edit and delete statuses

  Background:
    Given I am logged as an admin user

  Scenario: View availability list
    Given I am on the index page
    Then I should see "heading.availability.list"