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

namespace WellCommerce\Bundle\CategoryBundle\Tests\Controller\Front;

use Doctrine\Common\Collections\Criteria;
use WellCommerce\Bundle\CategoryBundle\Entity\CategoryInterface;
use WellCommerce\Bundle\CoreBundle\Test\Controller\Admin\AbstractAdminControllerTestCase;

/**
 * Class CategoryControllerTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CategoryControllerTest extends AbstractAdminControllerTestCase
{
    public function testIndexAction()
    {
        $collection = $this->container->get('category.repository')->matching(new Criteria());

        $collection->map(function (CategoryInterface $category) {
            $url     = $this->generateUrl('dynamic_' . $category->translate()->getRoute()->getId());
            $crawler = $this->client->request('GET', $url);

            $this->assertTrue($this->client->getResponse()->isSuccessful());
            $this->assertGreaterThan(0, $crawler->filter('html:contains("' . $category->translate()->getName() . '")')->count());
        });
    }
}
