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

namespace WellCommerce\Bundle\PaymentBundle\Tests\Controller\Admin;

use Doctrine\Common\Collections\Criteria;
use WellCommerce\Bundle\CoreBundle\Test\Controller\Admin\AbstractAdminControllerTestCase;
use WellCommerce\Bundle\PaymentBundle\Entity\PaymentMethodInterface;

/**
 * Class PaymentMethodControllerTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class PaymentMethodControllerTest extends AbstractAdminControllerTestCase
{
    public function testIndexAction()
    {
        $url     = $this->generateUrl('admin.payment_method.index');
        $crawler = $this->client->request('GET', $url);

        $this->assertTrue($this->client->getResponse()->isSuccessful(), 'Wrong response code');
        $this->assertEquals(1, $crawler->filter('html:contains("' . $this->trans('payment_method.heading.index') . '")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("' . $this->jsDataGridClass . '")')->count(), 'No datagrid');
        $this->assertEquals(0, $crawler->filter('html:contains("' . $this->jsFormClass . '")')->count(), 'Form exists');
    }

    public function testAddAction()
    {
        $url     = $this->generateUrl('admin.payment_method.add');
        $crawler = $this->client->request('GET', $url);

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertEquals(1, $crawler->filter('html:contains("' . $this->trans('payment_method.heading.add') . '")')->count());
        $this->assertEquals(0, $crawler->filter('html:contains("' . $this->jsDataGridClass . '")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("' . $this->jsFormClass . '")')->count());
    }

    public function testEditAction()
    {
        $collection = $this->container->get('payment_method.repository')->matching(new Criteria());

        $collection->map(function (PaymentMethodInterface $method) {
            $url     = $this->generateUrl('admin.payment_method.edit', ['id' => $method->getId()]);
            $crawler = $this->client->request('GET', $url);

            $this->assertTrue($this->client->getResponse()->isSuccessful());
            $this->assertEquals(1, $crawler->filter('html:contains("' . $this->trans('payment_method.heading.edit') . '")')->count());
            $this->assertEquals(0, $crawler->filter('html:contains("' . $this->jsDataGridClass . '")')->count());
            $this->assertEquals(1, $crawler->filter('html:contains("' . $this->jsFormClass . '")')->count());
            $this->assertEquals(1, $crawler->filter('html:contains("' . $method->translate()->getName() . '")')->count());
        });
    }

    public function testGridAction()
    {
        $this->client->request('GET', $this->generateUrl('admin.payment_method.grid'), [], [], [
            'HTTP_X-Requested-With' => 'XMLHttpRequest',
        ]);
    
        $this->assertTrue($this->client->getResponse()->isSuccessful());
    }
}
