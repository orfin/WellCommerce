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
     * Constructor
     *
     * @param RequestStack $requestStack
     */
    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
        $this->request      = $requestStack->getMasterRequest();
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
        if (null !== $this->request && $this->request->hasSession()) {
            return $this->request->getSession()->get($name, $default);
        }

        return $default;
    }

    /**
     * {@inheritdoc}
     */
    public function setSessionAttribute($name, $value)
    {
        if (null === $this->request || false === $this->request->hasSession()) {
            throw new \LogicException('Cannot set session attributes without valid session.');
        }

        return $this->request->getSession()->set($name, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function hasSessionAttribute($name)
    {
        if (null !== $this->request && $this->request->hasSession()) {
            return $this->request->getSession()->has($name);
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function getSessionId()
    {
        if (null !== $this->request && $this->request->hasSession()) {
            return $this->request->getSession()->getId();
        }

        return '';
    }

    /**
     * {@inheritdoc}
     */
    public function getSessionName()
    {
        if (null !== $this->request && $this->request->hasSession()) {
            return $this->request->getSession()->getName();
        }

        return '';
    }

    /**
     * {@inheritdoc}
     */
    public function hasRequestBagParam($name)
    {
        return $this->request->request->has($name);
    }

    /**
     * {@inheritdoc}
     */
    public function hasRequestBagParams(array $params = [])
    {
        foreach ($params as $param) {
            if (!$this->hasRequestBagParam($param)) {
                return false;
            }
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function getRequestBagParam($name, $default = null)
    {
        if (false === $this->hasRequestBagParam($name)) {
            return $default;
        }

        return $this->request->request->get($name, $default);
    }

    /**
     * {@inheritdoc}
     */
    public function getQueryBagParam($name, $default = null)
    {
        if (false === $this->request->query->has($name)) {
            return $default;
        }

        return $this->request->query->get($name, $default);
    }

    /**
     * {@inheritdoc}
     */
    public function hasAttributesBagParam($name)
    {
        return $this->request->attributes->has($name);
    }

    /**
     * {@inheritdoc}
     */
    public function hasAttributesBagParams(array $params = [])
    {
        foreach ($params as $param) {
            if (!$this->hasAttributesBagParam($param)) {
                return false;
            }
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function getAttributesBagParam($name, $default = null)
    {
        if (false === $this->hasAttributesBagParam($name)) {
            return $default;
        }

        return $this->request->attributes->get($name, $default);
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
        $page = (int)$this->getQueryBagParam('page', 1);
        $page = abs($page);

        return ($page > 0) ? $page : 1;
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrentLimit($default = 10)
    {
        $limit = $this->getQueryBagParam('limit', $default);
        $limit = abs($limit);

        return ($limit > 0) ? $limit : $default;
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrentLocale()
    {
        return $this->request->getLocale();
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrentCurrency()
    {
        return $this->getSessionAttribute('_currency');
    }
}
