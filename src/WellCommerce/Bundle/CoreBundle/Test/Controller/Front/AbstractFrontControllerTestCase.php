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

namespace WellCommerce\Bundle\CoreBundle\Test\Controller\Front;

use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use WellCommerce\Bundle\CoreBundle\Test\AbstractTestCase;

/**
 * Class AbstractFrontControllerTestCase
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AbstractFrontControllerTestCase extends AbstractTestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    protected function logIn()
    {
        $client   = $this->container->get('client.repository')->findOneBy([]);
        $session  = $this->client->getContainer()->get('session');
        $firewall = 'client';
        $token    = new UsernamePasswordToken('demo@wellcommerce.org', 'demo', $firewall, ['ROLE_CLIENT']);
        $token->setUser($client);

        $session->set('_security_' . $firewall, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);

        $this->container->get('security.token_storage')->setToken($token);
    }

    protected function logOut()
    {
        $this->client->request('GET', $this->generateUrl('front.client.logout'));
    }

    /**
     * Returns an URL generated for route
     *
     * @param string     $routeName
     * @param array      $params
     * @param bool|false $absolute
     *
     * @return string
     */
    protected function generateUrl($routeName, array $params = [], $absolute = false)
    {
        return $this->container->get('router')->generate($routeName, $params, $absolute);
    }

    /**
     * Returns a translated phrase
     *
     * @param string $message
     *
     * @return string
     */
    protected function trans($message, $domain = 'wellcommerce')
    {
        return $this->container->get('translator.helper')->trans($message, [], $domain);
    }
}
