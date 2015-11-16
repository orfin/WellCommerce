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

namespace WellCommerce\Bundle\CommonBundle\Resolver\Admin;

use WellCommerce\Bundle\CommonBundle\Resolver\AbstractShopResolver;
use WellCommerce\Bundle\CommonBundle\Resolver\ShopResolverInterface;

/**
 * Class ShopResolver
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ShopResolver extends AbstractShopResolver implements ShopResolverInterface
{
    /**
     * {@inheritdoc}
     */
    public function resolve()
    {
        $host          = $this->requestHelper->getCurrentHost();
        $attributeName = $this->context->getSessionAttributeName();
        $currentShopId = $this->requestHelper->getSessionAttribute($attributeName);
        if (null === $currentShopId) {
            $shop = $this->repository->findOneBy(['url' => $host]);
        } else {
            $shop = $this->repository->findOneBy(['id' => $currentShopId]);
        }

        if (null === $shop) {
            $shop = $this->getDefaultShop();
        }

        $this->context->setCurrentShop($shop);
        $this->requestHelper->setSessionAttribute($attributeName, $currentShopId);
    }
}
