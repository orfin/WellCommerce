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
use WellCommerce\Bundle\ProducerBundle\Entity\ProducerInterface;

/**
 * Class ProducerControllerTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProducerControllerTest extends AbstractAdminControllerTestCase
{
    public function testIndexAction()
    {
        $collection = $this->container->get('producer.repository')->matching(new Criteria());

        $collection->map(function (ProducerInterface $producer) {
            $url     = $this->generateUrl('dynamic_' . $producer->translate()->getRoute()->getId());
            $crawler = $this->client->request('GET', $url);

            $this->assertTrue($this->client->getResponse()->isSuccessful());
            $this->assertGreaterThan(0, $crawler->filter('html:contains("' . $producer->translate()->getName() . '")')->count());
        });
    }
}
