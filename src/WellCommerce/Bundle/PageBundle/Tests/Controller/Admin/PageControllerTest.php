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

namespace WellCommerce\Bundle\PageBundle\Tests\Controller\Admin;

use Doctrine\Common\Collections\Criteria;
use WellCommerce\Bundle\CoreBundle\Test\Controller\Admin\AbstractAdminControllerTestCase;
use WellCommerce\Bundle\PageBundle\Entity\PageInterface;

/**
 * Class PageControllerTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class PageControllerTest extends AbstractAdminControllerTestCase
{
    public function testIndexAction()
    {
        $url     = $this->generateUrl('admin.page.index');
        $crawler = $this->client->request('GET', $url);

        $this->assertTrue($this->client->getResponse()->isSuccessful(), 'Wrong response code');
        $this->assertEquals(1, $crawler->filter('html:contains("' . $this->trans('page.heading.index') . '")')->count(),
            $this->trans('page.heading.index'));
        $this->assertEquals(1, $crawler->filter('html:contains("' . $this->jsDataGridClass . '")')->count(), 'No datagrid');
        $this->assertEquals(0, $crawler->filter('html:contains("' . $this->jsFormClass . '")')->count(), 'Form exists');
    }

    public function testAddAction()
    {
        $url     = $this->generateUrl('admin.page.add');
        $crawler = $this->client->request('GET', $url);

        $this->assertTrue($this->client->getResponse()->isSuccessful(),
            'Wrong response code: ' . $this->client->getResponse()->getStatusCode());
        $this->assertEquals(1, $crawler->filter('html:contains("' . $this->trans('page.heading.add') . '")')->count(),
            'Heading is missing');
        $this->assertEquals(0, $crawler->filter('html:contains("' . $this->jsDataGridClass . '")')->count(),
            'Datagrid instance exists on page');
        $this->assertEquals(1, $crawler->filter('html:contains("' . $this->jsFormClass . '")')->count(), 'There is no form on page');
    }

    public function testEditAction()
    {
        $collection = $this->container->get('page.repository')->matching(new Criteria());

        $collection->map(function (PageInterface $page) {
            $url     = $this->generateUrl('admin.page.edit', ['id' => $page->getId()]);
            $crawler = $this->client->request('GET', $url);

            $this->assertTrue($this->client->getResponse()->isSuccessful());
            $this->assertEquals(1, $crawler->filter('html:contains("' . $this->trans('page.heading.edit') . '")')->count());
            $this->assertEquals(0, $crawler->filter('html:contains("' . $this->jsDataGridClass . '")')->count());
            $this->assertEquals(1, $crawler->filter('html:contains("' . $this->jsFormClass . '")')->count());
            $this->assertEquals(1, $crawler->filter('html:contains("' . $page->translate()->getName() . '")')->count());
        });
    }

    public function testGridAction()
    {
        $this->client->request('GET', $this->generateUrl('admin.page.grid'), [], [], [
            'HTTP_X-Requested-With' => 'XMLHttpRequest',
        ]);
    
        $this->assertTrue($this->client->getResponse()->isSuccessful());
    }
}
