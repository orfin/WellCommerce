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

namespace WellCommerce\Bundle\DistributionBundle\Factory;

use WellCommerce\Bundle\DistributionBundle\Entity\PackageInterface;
use WellCommerce\Bundle\DoctrineBundle\Factory\AbstractEntityFactory;

/**
 * Class ChannelFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class PackageFactory extends AbstractEntityFactory
{
    public function create() : PackageInterface
    {
        /** @var  $package PackageInterface */
        $package = $this->init();

        return $package;
    }
}
