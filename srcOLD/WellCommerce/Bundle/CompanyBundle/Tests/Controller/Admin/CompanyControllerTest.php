<?php
/*
 * WellCommerce Open-Source E-Commerce Platform
 * 
 * This file is part of the WellCommerce package.
 *
 * (c) Adam Piotrowski <adam@wellcommerce.org>
 * 
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */

namespace WellCommerce\Bundle\CompanyBundle\Tests\Controller\Admin;

use Doctrine\Common\Collections\Criteria;
use WellCommerce\Bundle\CompanyBundle\Entity\CompanyInterface;
use WellCommerce\Bundle\CoreBundle\Test\Controller\Admin\AbstractAdminControllerTestCase;

/**
 * Class CompanyControllerTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CompanyControllerTest extends AbstractAdminControllerTestCase
{
    public function testIndexAction()
    {
        $url     = $this->generateUrl('admin.company.index');
        $crawler = $this->client->request('GET', $url);

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertEquals(1, $crawler->filter('html:contains("' . $this->trans('company.heading.index') . '")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("' . $this->jsDataGridClass . '")')->count());
        $this->assertEquals(0, $crawler->filter('html:contains("' . $this->jsFormClass . '")')->count());
    }

    public function testAddAction()
    {
        $url     = $this->generateUrl('admin.company.add');
        $crawler = $this->client->request('GET', $url);

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertEquals(1, $crawler->filter('html:contains("' . $this->trans('company.heading.add') . '")')->count());
        $this->assertEquals(0, $crawler->filter('html:contains("' . $this->jsDataGridClass . '")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("' . $this->jsFormClass . '")')->count());
    }

    public function testEditAction()
    {
        $collection = $this->container->get('company.repository')->matching(new Criteria());

        $collection->map(function (CompanyInterface $company) {
            $url     = $this->generateUrl('admin.company.edit', ['id' => $company->getId()]);
            $crawler = $this->client->request('GET', $url);

            $this->assertTrue($this->client->getResponse()->isSuccessful());
            $this->assertEquals(1, $crawler->filter('html:contains("' . $this->trans('company.heading.edit') . '")')->count());
            $this->assertEquals(0, $crawler->filter('html:contains("' . $this->jsDataGridClass . '")')->count());
            $this->assertEquals(1, $crawler->filter('html:contains("' . $this->jsFormClass . '")')->count());
            $this->assertEquals(1, $crawler->filter('html:contains("' . $company->getName() . '")')->count());
        });
    }

    public function testGridAction()
    {
        $this->client->request('GET', $this->generateUrl('admin.company.grid'));
        $this->assertTrue($this->client->getResponse()->isRedirect($this->generateUrl('admin.company.index', [], true)));
    }
}
