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
use WellCommerce\CatalogBundle\Entity\CategoryInterface;
use WellCommerce\CoreBundle\Test\Controller\Admin\AbstractAdminControllerTestCase;

/**
 * Class CategoryControllerTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CategoryControllerTest extends AbstractAdminControllerTestCase
{
    public function testEditAction()
    {
        $collection = $this->container->get('category.repository')->matching(new Criteria());

        $collection->map(function (CategoryInterface $category) {
            $url     = $this->generateUrl('admin.category.edit', ['id' => $category->getId()]);
            $crawler = $this->client->request('GET', $url);

            $this->assertTrue($this->client->getResponse()->isSuccessful());
            $this->assertEquals(1, $crawler->filter('html:contains("' . $this->trans('category.heading.edit') . '")')->count());
            $this->assertEquals(1, $crawler->filter('html:contains("' . $this->jsFormClass . '")')->count());
            $this->assertEquals(1, $crawler->filter('html:contains("' . $category->translate()->getName() . '")')->count());
        });
    }
}
