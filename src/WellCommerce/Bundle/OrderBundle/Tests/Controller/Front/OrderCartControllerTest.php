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

namespace WellCommerce\Bundle\OrderBundle\Tests\Controller\Front;

use Doctrine\Common\Collections\Criteria;
use WellCommerce\Bundle\CoreBundle\Test\Controller\Front\AbstractFrontControllerTestCase;
use WellCommerce\Bundle\ProductBundle\Entity\ProductInterface;

/**
 * Class OrderControllerTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class OrderCartControllerTest extends AbstractFrontControllerTestCase
{
    public function testAddAction()
    {
        $collection = $this->container->get('product.repository')->matching(new Criteria());
        
        $collection->map(function (ProductInterface $product) {
            $url     = $this->generateUrl('front.order_cart.add', ['id' => $product->getId(), 'variant' => null, 'quantity' => 1]);
            $crawler = $this->client->request('GET', $url);
            
            if ($product->getVariants()->count()) {
                $redirectUrl = $this->generateUrl('front.product.view', ['id' => $product->getId()]);
                $this->assertTrue($this->client->getResponse()->isRedirect($redirectUrl));
            } else {
                $this->assertTrue($this->client->getResponse()->isSuccessful());
                $this->assertJson($this->client->getResponse()->getContent());
            }
        });
    }
    
    public function testIndexAction()
    {
        $url     = $this->generateUrl('front.order_cart.index');
        $crawler = $this->client->request('GET', $url);
        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertEquals(1, $crawler->filter('html:contains("' . $this->trans('order.heading.edit') . '")')->count());
    }
}
