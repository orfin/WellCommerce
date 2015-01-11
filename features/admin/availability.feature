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
    When I fill in "required_data[translations][pl][name]" with "72h"
    And I fill in "required_data[translations][en][name]" with "72h"
    And I press "Save"
    And I wait for the message bar to appear
    Then I should see "Success!"

  Scenario: Deleting availability entry
    Given I am on the index page
    When I wait for the datagrid to finish loading
    And I click "Delete" near "72h"
    And I wait for the message bar to appear
    And I follow "OK"
    And I wait for the message bar to appear
    Then I should see "72h successfully deleted"