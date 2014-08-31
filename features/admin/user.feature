@user
Feature: Manage admin users
  In order to manage users
  As a manager
  I should be able to see user list and manage users

  Background:
	Given I am logged as an admin user

  Scenario: View user list
	Given I am on the index page
	Then I should see "heading.user.list"