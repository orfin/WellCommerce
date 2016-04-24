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

namespace WellCommerce\Bundle\ShippingBundle\Provider;

use Doctrine\Common\Collections\Collection;
use WellCommerce\Bundle\ShippingBundle\Calculator\ShippingSubjectInterface;
use WellCommerce\Bundle\ShippingBundle\Entity\ShippingMethodInterface;

/**
 * Interface ShippingMethodProviderInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ShippingMethodProviderInterface
{
    public function getCosts(ShippingSubjectInterface $subject) : Collection;

    public function getShippingMethodCosts(ShippingMethodInterface $method, ShippingSubjectInterface $subject) : Collection;
}
