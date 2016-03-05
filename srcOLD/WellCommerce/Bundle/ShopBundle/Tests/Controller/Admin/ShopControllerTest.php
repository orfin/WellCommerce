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

namespace WellCommerce\Bundle\ShopBundle\Tests\Controller\Admin;

use Doctrine\Common\Collections\Criteria;
use WellCommerce\Bundle\CoreBundle\Test\Controller\Admin\AbstractAdminControllerTestCase;
use WellCommerce\Bundle\ShopBundle\Entity\ShopInterface;

/**
 * Class ShopControllerTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ShopControllerTest extends AbstractAdminControllerTestCase
{
    public function testIndexAction()
    {
        $url     = $this->generateUrl('admin.shop.index');
        $crawler = $this->client->request('GET', $url);

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertEquals(1, $crawler->filter('html:contains("' . $this->trans('shop.heading.index') . '")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("' . $this->jsDataGridClass . '")')->count());
        $this->assertEquals(0, $crawler->filter('html:contains("' . $this->jsFormClass . '")')->count());
    }

    public function testAddAction()
    {
        $url     = $this->generateUrl('admin.shop.add');
        $crawler = $this->client->request('GET', $url);

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertEquals(1, $crawler->filter('html:contains("' . $this->trans('shop.heading.add') . '")')->count());
        $this->assertEquals(0, $crawler->filter('html:contains("' . $this->jsDataGridClass . '")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("' . $this->jsFormClass . '")')->count());
    }

    public function testEditAction()
    {
        $collection = $this->container->get('shop.repository')->matching(new Criteria());

        $collection->map(function (ShopInterface $shop) {
            $url     = $this->generateUrl('admin.shop.edit', ['id' => $shop->getId()]);
            $crawler = $this->client->request('GET', $url);

            $this->assertTrue($this->client->getResponse()->isSuccessful());
            $this->assertEquals(1, $crawler->filter('html:contains("' . $this->trans('shop.heading.edit') . '")')->count());
            $this->assertEquals(0, $crawler->filter('html:contains("' . $this->jsDataGridClass . '")')->count());
            $this->assertEquals(1, $crawler->filter('html:contains("' . $this->jsFormClass . '")')->count());
            $this->assertEquals(1, $crawler->filter('html:contains("' . $shop->getName() . '")')->count());
        });
    }

    public function testGridAction()
    {
        $this->client->request('GET', $this->generateUrl('admin.shop.grid'));
        $this->assertTrue($this->client->getResponse()->isRedirect($this->generateUrl('admin.shop.index', [], true)));
    }
}
