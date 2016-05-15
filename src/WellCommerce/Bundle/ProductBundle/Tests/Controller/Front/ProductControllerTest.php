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

namespace WellCommerce\Bundle\ProductBundle\Tests\Controller\Front;

use Doctrine\Common\Collections\Criteria;
use WellCommerce\Bundle\CoreBundle\Test\Controller\Admin\AbstractAdminControllerTestCase;
use WellCommerce\Bundle\ProductBundle\Entity\ProductInterface;

/**
 * Class ProductControllerTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductControllerTest extends AbstractAdminControllerTestCase
{
    public function testIndexAction()
    {
        $collection = $this->container->get('product.repository')->matching(new Criteria());

        $collection->map(function (ProductInterface $product) {
            $url     = $this->generateUrl('dynamic_' . $product->translate()->getRoute()->getId());
            $crawler = $this->client->request('GET', $url);

            $this->assertTrue($this->client->getResponse()->isSuccessful(), sprintf(
                'Code: %s, URL: %s',
                $this->client->getResponse()->getStatusCode(),
                $url
            ));
            $this->assertGreaterThan(0, $crawler->filter('html:contains("' . $product->translate()->getName() . '")')->count());
        });
    }
}
