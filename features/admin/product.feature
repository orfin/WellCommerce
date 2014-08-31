@product
Feature: Manage products
  In order to create shop catalog
  As a shop owner
  I should be able to manage products

  Background:
	Given I am logged as an admin user

  Scenario: View product list
	Given I am on the index page
	Then I should see "Products"