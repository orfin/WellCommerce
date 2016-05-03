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

use WellCommerce\Bundle\DoctrineBundle\Repository\RepositoryInterface;
use WellCommerce\Bundle\ShopBundle\Entity\ShopInterface;

/**
 * Interface ShopRepositoryInterface
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
interface ShopRepositoryInterface extends RepositoryInterface
{
    public function resolve(int $currentShopId, string $host) : ShopInterface;
}
