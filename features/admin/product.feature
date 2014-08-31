@product
Feature: Manage products
  In order to manage product
  As a manager
  I should be able to see product list, add, edit and delete products

  Background:
	Given I am logged as an admin user

  Scenario: View user list
	Given I am on the index page
	Then I should see "heading.user.list"