@dashboard
Feature: Access dashboard
  In order to see an overview of shop sales
  As a manager
  I should be able to see graphs and basic reporting on dashboard page

  Background:
	Given I am logged as an administrator

  Scenario: View dashboard page
	Given I am on the dashboard page
	Then I should see "Dashboard"