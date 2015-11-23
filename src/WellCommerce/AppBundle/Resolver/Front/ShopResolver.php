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

namespace WellCommerce\AppBundle\Resolver\Front;

use WellCommerce\AppBundle\Resolver\AbstractShopResolver;
use WellCommerce\AppBundle\Resolver\ShopResolverInterface;

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
        $host = $this->requestHelper->getCurrentHost();
        $shop = $this->repository->findOneBy(['url' => $host]);
        if (null === $shop) {
            $shop = $this->getDefaultShop();
        }

        $this->context->setCurrentShop($shop);
    }
}
