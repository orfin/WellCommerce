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

namespace WellCommerce\Bundle\DoctrineBundle\Enhancer;

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
    public function getSupportedEntityClass();

    /**
     * Returns the class name supported by enhancer
     *
     * @return string
     */
    public function getSupportedEntityExtraTraitClass();

    /**
     * Checks whether the enhances supports entity
     *
     * @param $className
     *
     * @return bool
     */
    public function supportsEntity($className);

    /**
     * Checks whether the enhancer supports entity extra trait
     *
     * @param $className
     *
     * @return bool
     */
    public function supportsEntityExtraTrait($className);
}
