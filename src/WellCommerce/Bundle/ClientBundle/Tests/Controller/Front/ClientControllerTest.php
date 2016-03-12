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

namespace WellCommerce\Bundle\ClientBundle\Tests\Controller\Front;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use WellCommerce\Bundle\CoreBundle\Test\Controller\Front\AbstractFrontControllerTestCase;

/**
 * Class ClientControllerTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ClientControllerTest extends AbstractFrontControllerTestCase
{
    public function testIndexNonLoggedAction()
    {
        $url     = $this->generateUrl('front.client.login');
        $crawler = $this->client->request('GET', $url);

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertEquals(1, $crawler->filter('html:contains("' . $this->trans('client.heading.login') . '")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("' . $this->trans('client.link.password_forgotten') . '")')->count());

        $this->logOut();
    }

    public function testIndexLoggedAction()
    {
        $this->logIn();

        $redirectUrl = $this->generateUrl('front.client_order.index', [], UrlGeneratorInterface::ABSOLUTE_URL);
        $this->client->request('GET', $this->generateUrl('front.client.login'));
        $this->assertTrue($this->client->getResponse()->isRedirect($redirectUrl));

        $this->logOut();
    }
}
