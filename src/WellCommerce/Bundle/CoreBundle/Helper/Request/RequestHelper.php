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

namespace WellCommerce\Bundle\CoreBundle\Helper\Request;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\SecurityContext;
use WellCommerce\Bundle\ClientBundle\Entity\Client;
use WellCommerce\Bundle\UserBundle\Entity\User;

/**
 * Class RequestHelper
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class RequestHelper implements RequestHelperInterface
{
    /**
     * @var RequestStack
     */
    protected $requestStack;

    /**
     * @var null|\Symfony\Component\HttpFoundation\Request
     */
    protected $request;

    /**
     * @var null|\Symfony\Component\HttpFoundation\Session\SessionInterface
     */
    protected $session;

    /**
     * @var SecurityContext
     */
    protected $securityContext;

    /**
     * Constructor
     *
     * @param RequestStack    $requestStack
     * @param SecurityContext $securityContext
     */
    public function __construct(RequestStack $requestStack, SecurityContext $securityContext)
    {
        $this->requestStack    = $requestStack;
        $this->request         = $requestStack->getMasterRequest();
        $this->session         = $this->request->getSession();
        $this->securityContext = $securityContext;
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrentHost()
    {
        if (null !== $url = $this->request->server->get('SERVER_NAME')) {
            return $url;
        }

        return parse_url($this->request->server->get('HTTP_HOST'), PHP_URL_HOST);
    }

    /**
     * {@inheritdoc}
     */
    public function getSessionAttribute($name, $default = null)
    {
        return $this->session->get($name, $default);
    }

    /**
     * {@inheritdoc}
     */
    public function hasSessionAttribute($name)
    {
        return $this->session->has($name);
    }

    /**
     * {@inheritdoc}
     */
    public function getSessionId()
    {
        return $this->session->getId();
    }

    /**
     * {@inheritdoc}
     */
    public function getRequestAttribute($name, $default = null)
    {
        return $this->request->request->get($name, $default);
    }

    /**
     * {@inheritdoc}
     */
    public function hasRequestAttribute($name)
    {
        return $this->request->request->has($name);
    }

    /**
     * {@inheritdoc}
     */
    public function getQueryAttribute($name, $default = null)
    {
        return $this->request->query->get($name, $default);
    }

    /**
     * {@inheritdoc}
     */
    public function hasQueryAttribute($name)
    {
        return $this->request->query->has($name);
    }

    /**
     * {@inheritdoc}
     */
    public function getAttribute($name, $default = null)
    {
        return $this->request->attributes->get($name, $default);
    }

    /**
     * {@inheritdoc}
     */
    public function hasAttribute($name)
    {
        return $this->request->attributes->has($name);
    }

    /**
     * {@inheritdoc}
     */
    public function getAdmin()
    {
        $admin = $this->getUser();

        if ($admin instanceof User) {
            return $admin;
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getClient()
    {
        $client = $this->getUser();

        if ($client instanceof Client) {
            return $client;
        }

        return null;
    }

    /**
     * Returns current user from security context
     *
     * @return mixed|null
     */
    protected function getUser()
    {
        $token = $this->securityContext->getToken();
        if (null !== $token) {
            return $token->getUser();
        }

        return null;
    }
}
