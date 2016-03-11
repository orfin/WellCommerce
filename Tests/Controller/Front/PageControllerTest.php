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
use WellCommerce\Bundle\CoreBundle\Test\Controller\Admin\AbstractAdminControllerTestCase;
use WellCommerce\Bundle\OrderBundle\Entity\PageInterface;

/**
 * Class PageControllerTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class PageControllerTest extends AbstractAdminControllerTestCase
{
    public function testIndexAction()
    {
        $collection = $this->container->get('page.repository')->matching(new Criteria());

        $collection->map(function (PageInterface $page) {
            $url     = $this->generateUrl('dynamic_' . $page->translate()->getRoute()->getId());
            $crawler = $this->client->request('GET', $url);

            $this->assertTrue($this->client->getResponse()->isSuccessful());
            $this->assertGreaterThan(0, $crawler->filter('html:contains("' . $page->translate()->getName() . '")')->count());
        });
    }
}
