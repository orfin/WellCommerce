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

namespace WellCommerce\Bundle\PluginBundle\Enhancer;

use Doctrine\ORM\Mapping\ClassMetadataInfo;
use Zend\Code\Generator\TraitGenerator;

/**
 * Interface MappingEnhancerInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface MappingEnhancerInterface
{
    public function visitClassMetadata(ClassMetadataInfo $metadata);

    public function visitTraitGenerator(TraitGenerator $generator);
}
