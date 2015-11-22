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

namespace WellCommerce\ClientBundle\Tests\Controller\Admin;

use Doctrine\Common\Collections\Criteria;
use WellCommerce\ClientBundle\Entity\ClientGroupInterface;
use WellCommerce\AppBundle\Test\Controller\Admin\AbstractAdminControllerTestCase;

/**
 * Class ClientGroupControllerTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ClientGroupControllerTest extends AbstractAdminControllerTestCase
{
    public function testIndexAction()
    {
        $url     = $this->generateUrl('admin.client_group.index');
        $crawler = $this->client->request('GET', $url);

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertEquals(1, $crawler->filter('html:contains("' . $this->trans('client_group.heading.index') . '")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("' . $this->jsDataGridClass . '")')->count());
        $this->assertEquals(0, $crawler->filter('html:contains("' . $this->jsFormClass . '")')->count());
    }

    public function testAddAction()
    {
        $url     = $this->generateUrl('admin.client_group.add');
        $crawler = $this->client->request('GET', $url);

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertEquals(1, $crawler->filter('html:contains("' . $this->trans('client_group.heading.add') . '")')->count());
        $this->assertEquals(0, $crawler->filter('html:contains("' . $this->jsDataGridClass . '")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("' . $this->jsFormClass . '")')->count());
    }

    public function testEditAction()
    {
        $collection = $this->container->get('client_group.repository')->matching(new Criteria());

        $collection->map(function (ClientGroupInterface $clientGroup) {
            $url     = $this->generateUrl('admin.client_group.edit', ['id' => $clientGroup->getId()]);
            $crawler = $this->client->request('GET', $url);

            $this->assertTrue($this->client->getResponse()->isSuccessful());
            $this->assertEquals(1, $crawler->filter('html:contains("' . $this->trans('client_group.heading.edit') . '")')->count());
            $this->assertEquals(0, $crawler->filter('html:contains("' . $this->jsDataGridClass . '")')->count());
            $this->assertEquals(1, $crawler->filter('html:contains("' . $this->jsFormClass . '")')->count());
            $this->assertEquals(1, $crawler->filter('html:contains("' . $clientGroup->translate()->getName() . '")')->count());
        });

    }

    public function testGridAction()
    {
        $this->client->request('GET', $this->generateUrl('admin.client_group.grid'));
        $this->assertTrue($this->client->getResponse()->isRedirect($this->generateUrl('admin.client_group.index', [], true)));
    }
}
