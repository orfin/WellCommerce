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

namespace WellCommerce\Bundle\AvailabilityBundle\Enhancer;

use WellCommerce\Bundle\DoctrineBundle\Definition\FieldDefinition;
use WellCommerce\Bundle\DoctrineBundle\Definition\MappingDefinitionCollection;
use WellCommerce\Bundle\DoctrineBundle\Enhancer\AbstractMappingEnhancer;

/**
 * Class AvailabilityMappingEnhancer
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AvailabilityMappingEnhancer extends AbstractMappingEnhancer
{
    /**
     * @param MappingDefinitionCollection $collection
     */
    protected function configureMappingDefinition(MappingDefinitionCollection $collection)
    {

    }

    public function getSupportedEntityClass()
    {
        return \WellCommerce\Bundle\AvailabilityBundle\Entity\Availability::class;
    }

    public function getSupportedEntityExtraTraitClass()
    {
        return \WellCommerce\Bundle\AvailabilityBundle\Entity\Extra\AvailabilityExtraTrait::class;
    }
}
