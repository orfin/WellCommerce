@producer
Feature: Manage producers
  In order to manage producers
  As a shop owner
  I should be able to list, add, edit and delete producer

  Background:
	Given I am logged as an administrator

  Scenario: View producer list
	Given I am on the index page
	Then I should see "heading.producer.list"