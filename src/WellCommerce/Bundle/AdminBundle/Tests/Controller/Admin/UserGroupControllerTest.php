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

namespace WellCommerce\Bundle\AdminBundle\Tests\Controller\Admin;

use Doctrine\Common\Collections\Criteria;
use WellCommerce\Bundle\AdminBundle\Entity\UserGroupInterface;
use WellCommerce\Bundle\CoreBundle\Test\Controller\Admin\AbstractAdminControllerTestCase;

/**
 * Class UserGroupControllerTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class UserGroupControllerTest extends AbstractAdminControllerTestCase
{
    public function testIndexAction()
    {
        $url     = $this->generateUrl('admin.user_group.index');
        $crawler = $this->client->request('GET', $url);
        
        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertEquals(1, $crawler->filter('html:contains("' . $this->trans('user_group.heading.index') . '")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("' . $this->jsDataGridClass . '")')->count());
        $this->assertEquals(0, $crawler->filter('html:contains("' . $this->jsFormClass . '")')->count());
    }
    
    public function testAddAction()
    {
        $url     = $this->generateUrl('admin.user_group.add');
        $crawler = $this->client->request('GET', $url);
        
        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertEquals(1, $crawler->filter('html:contains("' . $this->trans('user_group.heading.add') . '")')->count());
        $this->assertEquals(0, $crawler->filter('html:contains("' . $this->jsDataGridClass . '")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("' . $this->jsFormClass . '")')->count());
    }
    
    
    public function testEditAction()
    {
        $collection = $this->container->get('user_group.repository')->matching(new Criteria());
        
        $collection->map(function (UserGroupInterface $user) {
            $url     = $this->generateUrl('admin.user_group.edit', ['id' => $user->getId()]);
            $crawler = $this->client->request('GET', $url);
            
            $this->assertTrue($this->client->getResponse()->isSuccessful());
            $this->assertEquals(1, $crawler->filter('html:contains("' . $this->trans('user_group.heading.edit') . '")')->count());
            $this->assertEquals(0, $crawler->filter('html:contains("' . $this->jsDataGridClass . '")')->count());
            $this->assertEquals(1, $crawler->filter('html:contains("' . $this->jsFormClass . '")')->count());
            $this->assertEquals(1, $crawler->filter('html:contains("' . $user->getName() . '")')->count());
        });
    }
    
    public function testGridAction()
    {
        $this->client->request('GET', $this->generateUrl('admin.user_group.grid'), [], [], [
            'HTTP_X-Requested-With' => 'XMLHttpRequest',
        ]);
        
        $this->assertTrue($this->client->getResponse()->isSuccessful(), $this->client->getResponse()->getContent());
    }
}
