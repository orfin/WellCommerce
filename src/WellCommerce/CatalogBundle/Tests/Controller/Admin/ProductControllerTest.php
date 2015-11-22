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

namespace WellCommerce\CatalogBundle\Tests\Controller\Admin;

use Doctrine\Common\Collections\Criteria;
use WellCommerce\CatalogBundle\Entity\ProductInterface;
use WellCommerce\AppBundle\Test\Controller\Admin\AbstractAdminControllerTestCase;

/**
 * Class ProductControllerTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductControllerTest extends AbstractAdminControllerTestCase
{
    public function testIndexAction()
    {
        $url     = $this->generateUrl('admin.product.index');
        $crawler = $this->client->request('GET', $url);

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertEquals(1, $crawler->filter('html:contains("' . $this->trans('product.heading.index') . '")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("' . $this->jsDataGridClass . '")')->count());
        $this->assertEquals(0, $crawler->filter('html:contains("' . $this->jsFormClass . '")')->count());
    }

    public function testAddAction()
    {
        $url     = $this->generateUrl('admin.product.add');
        $crawler = $this->client->request('GET', $url);

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertEquals(1, $crawler->filter('html:contains("' . $this->trans('product.heading.add') . '")')->count());
        $this->assertEquals(0, $crawler->filter('html:contains("' . $this->jsDataGridClass . '")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("' . $this->jsFormClass . '")')->count());
    }

    public function testEditAction()
    {
        $collection = $this->container->get('product.repository')->matching(new Criteria());

        $collection->map(function (ProductInterface $product) {
            $url     = $this->generateUrl('admin.product.edit', ['id' => $product->getId()]);
            $crawler = $this->client->request('GET', $url);

            $this->assertTrue($this->client->getResponse()->isSuccessful());
            $this->assertEquals(1, $crawler->filter('html:contains("' . $this->trans('product.heading.edit') . '")')->count());
            $this->assertEquals(0, $crawler->filter('html:contains("' . $this->jsDataGridClass . '")')->count());
            $this->assertEquals(1, $crawler->filter('html:contains("' . $this->jsFormClass . '")')->count());
            $this->assertEquals(1, $crawler->filter('html:contains("' . $product->translate()->getName() . '")')->count());
        });
    }

    public function testGridAction()
    {
        $this->client->request('GET', $this->generateUrl('admin.product.grid'));
        $this->assertTrue($this->client->getResponse()->isRedirect($this->generateUrl('admin.product.index', [], true)));
    }
}
