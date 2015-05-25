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

namespace WellCommerce\Bundle\MultiStoreBundle\Context;

use Doctrine\Common\Util\Debug;
use Symfony\Component\HttpFoundation\RequestStack;
use WellCommerce\Bundle\MultiStoreBundle\Entity\Shop;
use WellCommerce\Bundle\MultiStoreBundle\Repository\ShopRepositoryInterface;

/**
 * Class AbstractShopContext
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractShopContext
{
    /**
     * @var RequestStack
     */
    protected $requestStack;

    /**
     * @var ShopRepositoryInterface
     */
    protected $repository;

    /**
     * @var \WellCommerce\Bundle\MultiStoreBundle\Entity\Shop
     */
    protected $currentScope;

    /**
     * Constructor
     *
     * @param RequestStack            $requestStack
     * @param ShopRepositoryInterface $repository
     */
    public function __construct(RequestStack $requestStack, ShopRepositoryInterface $repository)
    {
        $this->requestStack = $requestStack;
        $this->repository   = $repository;
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrentScope()
    {
        return $this->currentScope;
    }

    /**
     * {@inheritdoc}
     */
    public function setCurrentScope(Shop $shop = null)
    {
        $this->currentScope = $shop;
        $this->setSessionVariables();
    }

    abstract public function setSessionVariables();

    /**
     * {@inheritdoc}
     */
    public function hasSessionPreviousData()
    {
        $sessionBag = $this->requestStack->getMasterRequest()->getSession();

        return (bool)$sessionBag->has($this->getSessionBagNamespace());
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrentScopeId()
    {
        if (null === $this->requestStack->getMasterRequest()) {
            return null;
        }

        $sessionBag = $this->requestStack->getMasterRequest()->getSession();
        $scope      = $sessionBag->get($this->getSessionBagNamespace());

        return isset($scope['id']) ? $scope['id'] : null;
    }

    /**
     * Sets current shop scope by url
     *
     * @param string $host
     */
    public function setCurrentScopeByHost($host)
    {
        $result = $this->repository->findOneBy(['url' => $host]);
        if (null !== $result) {
            $this->setCurrentScope($result);
        }
    }

    /**
     * Determines current scope by host
     *
     * @param $host
     */
    public function determineCurrentScope($host)
    {
        $this->setCurrentScopeByHost($host);
    }

    /**
     * {@inheritdoc}
     */
    abstract public function getSessionBagNamespace();
}
