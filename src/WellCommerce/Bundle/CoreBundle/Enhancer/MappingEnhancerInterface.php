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

namespace WellCommerce\Bundle\CoreBundle\Enhancer;

use Doctrine\ORM\Mapping\ClassMetadataInfo;
use Wingu\OctopusCore\CodeGenerator\PHP\OOP\TraitGenerator;

/**
 * Interface MappingEnhancerInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface MappingEnhancerInterface
{
    /**
     * @param ClassMetadataInfo $metadata
     */
    public function visitClassMetadata(ClassMetadataInfo $metadata);

    /**
     * @param TraitGenerator $generator
     */
    public function visitTraitGenerator(TraitGenerator $generator);

    /**
     * Returns the class name supported by enhancer
     *
     * @return string
     */
    public function getSupportedEntityClass() : string;

    /**
     * Returns the class name supported by enhancer
     *
     * @return string
     */
    public function getSupportedEntityExtraTraitClass() : string;

    /**
     * Checks whether the enhances supports entity
     *
     * @param string $className
     *
     * @return bool
     */
    public function supportsEntity(string $className) : bool;

    /**
     * Checks whether the enhancer supports entity extra trait
     *
     * @param string $className
     *
     * @return bool
     */
    public function supportsEntityExtraTrait(string $className) : bool;
}
