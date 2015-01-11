@availability
Feature: Manage availability statuses
  In order to manage availability statuses
  As a administrator
  I should be able to see the list and add, edit and delete statuses

  Background:
    Given I am logged as an administrator

  Scenario: View availability statuses
    Given I am on the index page
    Then I should see "heading.availability.list"

  Scenario: Creating new availability entry
    Given I am on the index page
    And I follow "Add"
    When I fill in "required_data[translations][pl][name]" with "72 godziny"
    And I fill in "required_data[translations][en][name]" with "72 hours"
    And I press "Save"
    Then I should return to index page
    And I should see "72 godziny"

  Scenario: Deleting availability entry
    Given I am on the index page
    When I click "Delete" near "72 godziny"
    And I wait for the message bar to appear
    And I follow "OK"
    And I wait for the message bar to appear
    Then I should see "72 godziny successfully deleted"