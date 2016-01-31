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

namespace WellCommerce\Bundle\DistributionBundle\Manipulator;

use WellCommerce\Bundle\DistributionBundle\Collection\MappingCollection;

/**
 * Interface MappingConfigurationManipulatorInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface MappingConfigurationManipulatorInterface
{
    /**
     * @param MappingCollection $collection
     * @param string            $mappingTargetPath
     */
    public function modifyMappedServices(MappingCollection $collection, $mappingTargetPath);
}
