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

namespace WellCommerce\Bundle\ShopBundle\Repository;

use WellCommerce\Bundle\CoreBundle\Repository\EntityRepository;
use WellCommerce\Bundle\ShopBundle\Entity\ShopInterface;

/**
 * Class ShopRepository
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class ShopRepository extends EntityRepository implements ShopRepositoryInterface
{
    public function resolve(int $currentShopId, string $url): ShopInterface
    {
        if (0 === $currentShopId) {
            $currentShop = $this->findOneBy(['url' => $url]);
            
            if ($currentShop instanceof ShopInterface) {
                return $currentShop;
            }
        }
        
        $currentShop = $this->find($currentShopId);
        if ($currentShop instanceof ShopInterface) {
            return $currentShop;
        }
        
        return $this->findOneBy([]);
    }
}
