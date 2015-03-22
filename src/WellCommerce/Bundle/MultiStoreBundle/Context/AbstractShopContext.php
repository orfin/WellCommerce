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

use Symfony\Component\HttpFoundation\RequestStack;
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
    abstract public function getSessionBagNamespace();

    /**
     * {@inheritdoc}
     */
    public function getCurrentScopeId()
    {
        $sessionBag = $this->requestStack->getMasterRequest()->getSession();
        $scope      = $sessionBag->get($this->getSessionBagNamespace());

        return isset($scope['id']) ? $scope['id'] : null;
    }
} 