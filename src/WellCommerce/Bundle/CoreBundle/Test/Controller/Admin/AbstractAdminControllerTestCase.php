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

namespace WellCommerce\Bundle\CoreBundle\Test\Controller\Admin;

use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use WellCommerce\Bundle\CoreBundle\Test\AbstractTestCase;

/**
 * Class AbstractAdminControllerTestCase
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AbstractAdminControllerTestCase extends AbstractTestCase
{
    protected $jsDataGridClass = 'GF_Datagrid';
    protected $jsFormClass     = 'GForm';

    public function setUp()
    {
        parent::setUp();
        $this->logIn();
    }

    protected function logIn()
    {
        $user     = $this->container->get('user.repository')->findOneBy([]);
        $currency = $this->container->get('currency.repository')->findOneBy([]);
        $session  = $this->client->getContainer()->get('session');
        $firewall = 'admin';
        $token    = new UsernamePasswordToken('admin', 'admin', $firewall, ['ROLE_ADMIN']);
        $token->setUser($user);

        $session->set('_currency', $currency->getCode());
        $session->set('_security_' . $firewall, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);

        $this->container->get('security.token_storage')->setToken($token);
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
