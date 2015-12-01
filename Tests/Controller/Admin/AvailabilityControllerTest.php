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

namespace WellCommerce\Bundle\AppBundle\Tests\Controller\Admin;

use Doctrine\Common\Collections\Criteria;
use WellCommerce\Bundle\AppBundle\Entity\AvailabilityInterface;
use WellCommerce\Bundle\CoreBundle\Test\Controller\Admin\AbstractAdminControllerTestCase;

/**
 * Class AvailabilityControllerTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AvailabilityControllerTest extends AbstractAdminControllerTestCase
{
    public function testIndexAction()
    {
        $url     = $this->generateUrl('admin.availability.index');
        $crawler = $this->client->request('GET', $url);

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertEquals(1, $crawler->filter('html:contains("' . $this->trans('availability.heading.index') . '")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("' . $this->jsDataGridClass . '")')->count());
        $this->assertEquals(0, $crawler->filter('html:contains("' . $this->jsFormClass . '")')->count());
    }

    public function testAddAction()
    {
        $url     = $this->generateUrl('admin.availability.add');
        $crawler = $this->client->request('GET', $url);

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertEquals(1, $crawler->filter('html:contains("' . $this->trans('availability.heading.add') . '")')->count());
        $this->assertEquals(0, $crawler->filter('html:contains("' . $this->jsDataGridClass . '")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("' . $this->jsFormClass . '")')->count());
    }

    public function testEditAction()
    {
        $collection = $this->container->get('availability.repository')->matching(new Criteria());

        $collection->map(function (AvailabilityInterface $availability) {
            $url     = $this->generateUrl('admin.availability.edit', ['id' => $availability->getId()]);
            $crawler = $this->client->request('GET', $url);

            $this->assertTrue($this->client->getResponse()->isSuccessful());
            $this->assertEquals(1, $crawler->filter('html:contains("' . $this->trans('availability.heading.edit') . '")')->count());
            $this->assertEquals(0, $crawler->filter('html:contains("' . $this->jsDataGridClass . '")')->count());
            $this->assertEquals(1, $crawler->filter('html:contains("' . $this->jsFormClass . '")')->count());
            $this->assertEquals(1, $crawler->filter('html:contains("' . $availability->translate()->getName() . '")')->count());
        });
    }

    public function testGridAction()
    {
        $this->client->request('GET', $this->generateUrl('admin.availability.grid'));
        $this->assertTrue($this->client->getResponse()->isRedirect($this->generateUrl('admin.availability.index', [], true)));
    }

}
