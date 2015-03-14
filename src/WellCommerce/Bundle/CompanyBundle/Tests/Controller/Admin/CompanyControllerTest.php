<?php

namespace WellCommerce\Bundle\CompanyBundle\Tests\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CompanyControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/admin/user/login');

        $this->assertTrue($crawler->filter('html:contains("Administration")')->count() > 0);
    }
}
