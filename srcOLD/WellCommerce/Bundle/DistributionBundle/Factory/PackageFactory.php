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

use WellCommerce\Bundle\CoreBundle\Factory\AbstractFactory;
use WellCommerce\Bundle\DistributionBundle\Entity\PackageInterface;

/**
 * Class ChannelFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class PackageFactory extends AbstractFactory
{
    /**
     * @var string
     */
    protected $supportsInterface = PackageInterface::class;

    /**
     * @return PackageInterface
     */
    public function create()
    {
        /** @var  $package PackageInterface */
        $package = $this->init();

        return $package;
    }
}
