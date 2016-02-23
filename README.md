README
======

[![Build Status](https://travis-ci.org/WellCommerce/WellCommerce.svg?branch=development)](https://travis-ci.org/WellCommerce/WellCommerce)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/98fa65a3-a9a0-4ae8-b7c9-27d3cc1cebb2/mini.png)](https://insight.sensiolabs.com/projects/98fa65a3-a9a0-4ae8-b7c9-27d3cc1cebb2)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/WellCommerce/WellCommerce/badges/quality-score.png?b=development)](https://scrutinizer-ci.com/g/WellCommerce/WellCommerce/?branch=development)
[![Total Downloads](https://poser.pugx.org/wellcommerce/wellcommerce/downloads.svg)](https://packagist.org/packages/wellcommerce/wellcommerce)
[![License](https://poser.pugx.org/wellcommerce/wellcommerce/license.svg)](https://packagist.org/packages/wellcommerce/wellcommerce)

What is WellCommerce?
---------------------

WellCommerce is an e-commerce platform for PHP 5.6.x and 7.x. It can be used to develop all kind of shops and extend them in the way you like.

The code is still hot but it only gets cooler :). Here are most important things which we have used to create this solution:

- [Symfony 3.1 Full-stack framework][1]
- [Doctrine 2.5 ORM][2]
- [PHPUnit 5 testing framework][3]
- [Twig template engine][4]
- [Twitter Bootstrap 3 as a base HTML framework][5]

Demo
------------

[![Home page](http://wellcommerce.org/web/assets/screens/mainside-m.png)](http://wellcommerce.org/web/assets/screens/mainside.png)
[![Product card](http://wellcommerce.org/web/assets/screens/product-m.png)](http://wellcommerce.org/web/assets/screens/product.png)
[![Products grid](http://wellcommerce.org/web/assets/screens/category-m.png)](http://wellcommerce.org/web/assets/screens/category.png)

- [Front-end][8]
- [Administration][9]

Default credentials for administration area:

    Login: admin
    
    Password: admin

Requirements
------------

WellCommerce is only supported on PHP 5.6.x and 7.x. Every next major release will require [actively supported PHP version][7]

Installation
------------

As WellCommerce uses [Composer][6] to manage its dependencies, the recommended way
to create a new project is to use it.

If you don't have Composer yet, download it following the instructions on
http://getcomposer.org/ or just run the following command:

    curl -s http://getcomposer.org/installer | php

Then, use the `create-project` command to generate a new WellCommerce application:

For developer/contributor edition use following command:

    php composer.phar create-project wellcommerce/wellcommerce -s dev path/to/wellcommerce

Composer will install WellCommerce and all its dependencies under the `path/to/wellcommerce` directory. You will be asked to enter configuration parameters during the install process.

After the download is complete, run following command to create a database, install assets and import sample data:

    cd path/to/wellcommerce
    php app/console wellcommerce:install

Contributors
------------

Every contributor is WellComme :). If you'd like to join us, please send a message at contributors@wellcommerce.org

You can also discuss and share your opinions on WellCommerce in our gitter chat:

[![Gitter](https://badges.gitter.im/Join Chat.svg)](https://gitter.im/WellCommerce/WellCommerce?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)

[1]:  http://symfony.com
[2]:  http://doctrine-project.org
[3]:  https://phpunit.de
[4]:  http://twig.sensiolabs.org
[5]:  http://getbootstrap.com
[6]:  http://getcomposer.org/
[7]:  http://php.net/supported-versions.php
[8]:  http://demo.wellcommerce.org
[9]:  http://demo.wellcommerce.org/admin
