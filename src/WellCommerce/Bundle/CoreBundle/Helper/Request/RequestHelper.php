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
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
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
     * @var TokenStorageInterface
     */
    protected $tokenStorage;

    /**
     * Constructor
     *
     * @param RequestStack          $requestStack
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct(RequestStack $requestStack, TokenStorageInterface $tokenStorage)
    {
        $this->requestStack = $requestStack;
        $this->request      = $requestStack->getMasterRequest();
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrentRequest()
    {
        return $this->request;
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrentHost()
    {
        if (null !== $url = $this->request->server->get('SERVER_NAME')) {
            return $url;
        }

        if (null !== $url = $this->request->server->get('HTTP_HOST')) {
            return parse_url($url, PHP_URL_HOST);
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getSessionAttribute($name, $default = null)
    {
        return $this->request->getSession()->get($name, $default);
    }

    /**
     * {@inheritdoc}
     */
    public function hasSessionAttribute($name)
    {
        return $this->request->getSession()->has($name);
    }

    /**
     * {@inheritdoc}
     */
    public function getSessionId()
    {
        return $this->request->getSession()->getId();
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
     * {@inheritdoc}
     */
    public function getCurrentOffset($limit)
    {
        $page   = $this->getCurrentPage();
        $offset = ($page * $limit) - $limit;

        return ($offset > 0) ? $offset : 0;
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrentPage()
    {
        $page = (int)$this->getQueryAttribute('page', 1);
        $page = abs($page);

        return ($page > 0) ? $page : 1;
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrentLimit($default = 10)
    {
        $limit = (int)$this->getQueryAttribute('limit', $default);
        $limit = abs($limit);

        return ($limit > 0) ? $limit : $default;
    }

    /**
     * Returns current user from security context
     *
     * @return mixed|null
     */
    protected function getUser()
    {
        $token = $this->tokenStorage->getToken();
        if (null !== $token) {
            return $token->getUser();
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrentLocale()
    {
        return $this->request->getLocale();
    }
}
