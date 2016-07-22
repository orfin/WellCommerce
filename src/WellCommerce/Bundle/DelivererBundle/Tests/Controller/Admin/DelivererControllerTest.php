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

namespace WellCommerce\Bundle\DelivererBundle\Tests\Controller\Admin;

use WellCommerce\Bundle\CoreBundle\Test\Controller\Admin\AbstractAdminControllerTestCase;
use WellCommerce\Bundle\DelivererBundle\Entity\DelivererInterface;

/**
 * Class DelivererControllerTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class DelivererControllerTest extends AbstractAdminControllerTestCase
{
    public function testIndexAction()
    {
        $url     = $this->generateUrl('admin.deliverer.index');
        $crawler = $this->client->request('GET', $url);

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertEquals(1, $crawler->filter('html:contains("' . $this->trans('deliverer.heading.index') . '")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("' . $this->jsDataGridClass . '")')->count());
        $this->assertEquals(0, $crawler->filter('html:contains("' . $this->jsFormClass . '")')->count());
    }

    public function testAddAction()
    {
        $url     = $this->generateUrl('admin.deliverer.add');
        $crawler = $this->client->request('GET', $url);

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertEquals(1, $crawler->filter('html:contains("' . $this->trans('deliverer.heading.add') . '")')->count());
        $this->assertEquals(0, $crawler->filter('html:contains("' . $this->jsDataGridClass . '")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("' . $this->jsFormClass . '")')->count());
    }

    /**
     * @dataProvider getEntitiesCollection
     */
    public function testEditAction(DelivererInterface $deliverer)
    {
        $url     = $this->generateUrl('admin.deliverer.edit', ['id' => $deliverer->getId()]);
        $crawler = $this->client->request('GET', $url);

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertEquals(1, $crawler->filter('html:contains("' . $this->trans('deliverer.heading.edit') . '")')->count());
        $this->assertEquals(0, $crawler->filter('html:contains("' . $this->jsDataGridClass . '")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("' . $this->jsFormClass . '")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("' . $deliverer->translate()->getName() . '")')->count());
    }

    public function testGridAction()
    {
        $this->client->request('GET', $this->generateUrl('admin.deliverer.grid'), [], [], [
            'HTTP_X-Requested-With' => 'XMLHttpRequest',
        ]);
    
        $this->assertTrue($this->client->getResponse()->isSuccessful());
    }

    /**
     * @return array
     */
    public function getEntitiesCollection()
    {
        $this->setUp();

        return [
            $this->container->get('deliverer.repository')->findAll()
        ];
    }
}
