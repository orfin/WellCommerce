README
======

[![Build Status](https://travis-ci.org/WellCommerce/WellCommerce.svg?branch=development)](https://travis-ci.org/WellCommerce/WellCommerce)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/WellCommerce/WellCommerce/badges/quality-score.png?b=development)](https://scrutinizer-ci.com/g/WellCommerce/WellCommerce/?branch=development)
[![Total Downloads](https://poser.pugx.org/wellcommerce/wellcommerce/downloads.svg)](https://packagist.org/packages/wellcommerce/wellcommerce)
[![License](https://poser.pugx.org/wellcommerce/wellcommerce/license.svg)](https://packagist.org/packages/wellcommerce/wellcommerce)

What is WellCommerce?
---------------------

WellCommerce is an e-commerce platform for PHP 5.4+. It can be used to develop all kind of shops and extend them in the way you like.

The code is still hot but it only gets cooler :). Here are most important things which we have used to create this solution:

- [Symfony2 Full-stack framework][1]
- [Doctrine2 ORM][2]
- [Behat BDD framework][3]
- [Twig template engine][4]
- [Twitter Bootstrap 3 as a base HTML framework][5]

Requirements
------------

WellCommerce is only supported on PHP 5.4 and up. 

Installation
------------

As WellCommerce uses [Composer][6] to manage its dependencies, the recommended way
to create a new project is to use it.

If you don't have Composer yet, download it following the instructions on
http://getcomposer.org/ or just run the following command:

    curl -s http://getcomposer.org/installer | php

Then, use the `create-project` command to generate a new WellCommerce application:

    php composer.phar create-project wellcommerce/wellcommerce -s dev path/to/wellcommerce

Composer will install WellCommerce and all its dependencies under the `path/to/wellcommerce` directory.

Contributors
------------

Every contributor is WellComme :). If you'd like to join us, please send a message at contributors@wellcommerce.org

[1]:  http://symfony.com
[2]:  http://doctrine-project.org
[3]:  http://behat.org
[4]:  http://twig.sensiolabs.org
[5]:  http://getbootstrap.com
[6]:  http://getcomposer.org/
