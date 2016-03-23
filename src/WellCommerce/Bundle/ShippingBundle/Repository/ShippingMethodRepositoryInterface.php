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

namespace WellCommerce\Bundle\ShippingBundle\Repository;

use WellCommerce\Bundle\DoctrineBundle\Repository\RepositoryInterface;

/**
 * Interface ShippingMethodRepositoryInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ShippingMethodRepositoryInterface extends RepositoryInterface
{
    /**
     * Returns default shipping method
     *
     * @return null|\WellCommerce\Bundle\ShippingBundle\Entity\ShippingMethodInterface
     */
    public function getDefaultShippingMethod();

    /**
     * @return array|\WellCommerce\Bundle\ShippingBundle\Entity\ShippingMethodInterface[]
     */
    public function findAllEnabledShippingMethods();
}
