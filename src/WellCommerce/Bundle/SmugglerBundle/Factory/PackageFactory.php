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

namespace WellCommerce\Bundle\SmugglerBundle\Factory;

use WellCommerce\Bundle\SmugglerBundle\Entity\Package;
use WellCommerce\Bundle\CoreBundle\Factory\AbstractFactory;
use WellCommerce\Bundle\CoreBundle\Factory\FactoryInterface;

/**
 * Class ChannelFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class PackageFactory extends AbstractFactory implements FactoryInterface
{
    /**
     * @return \WellCommerce\Bundle\SmugglerBundle\Entity\PackageInterface
     */
    public function create()
    {
        $package = new Package();

        return $package;
    }
}
