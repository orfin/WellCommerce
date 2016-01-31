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

namespace WellCommerce\Bundle\PluginBundle\Visitor\ClassMetadata;

use Doctrine\ORM\Mapping\ClassMetadataInfo;

/**
 * Interface ClassMetadataVisitorInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ClassMetadataVisitorInterface
{
    /**
     * @param ClassMetadataInfo $metadata
     */
    public function visit(ClassMetadataInfo $metadata);

    /**
     * @return \WellCommerce\Bundle\PluginBundle\Definition\MappingDefinitionCollection
     */
    public function getMappingDefinitionCollection();

    /**
     * @return string
     */
    public function getSupportedClass();
}
