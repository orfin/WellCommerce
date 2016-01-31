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

namespace WellCommerce\Bundle\ShopBundle\Resolver;

use WellCommerce\Bundle\CoreBundle\Helper\Request\RequestHelperInterface;
use WellCommerce\Bundle\ShopBundle\Context\ShopContextInterface;
use WellCommerce\Bundle\ShopBundle\Repository\ShopRepositoryInterface;

/**
 * Class AbstractShopResolver
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractShopResolver
{
    /**
     * @var ShopRepositoryInterface
     */
    protected $repository;

    /**
     * @var RequestHelperInterface
     */
    protected $requestHelper;

    /**
     * @var ShopContextInterface
     */
    protected $context;

    /**
     * Constructor
     *
     * @param ShopContextInterface    $context
     * @param ShopRepositoryInterface $repository
     * @param RequestHelperInterface  $requestHelper
     */
    public function __construct(ShopContextInterface $context, ShopRepositoryInterface $repository, RequestHelperInterface $requestHelper)
    {
        $this->context       = $context;
        $this->repository    = $repository;
        $this->requestHelper = $requestHelper;
    }

    /**
     * {@inheritdoc}
     */
    abstract public function resolve();

    /**
     * @return \WellCommerce\Bundle\ShopBundle\Entity\ShopInterface
     */
    protected function getDefaultShop()
    {
        $shop = $this->repository->findOneBy([]);
        if (null === $shop) {
            throw new \RuntimeException('Cannot load multistore data. Check stores configuration.');
        }

        return $shop;
    }
}
