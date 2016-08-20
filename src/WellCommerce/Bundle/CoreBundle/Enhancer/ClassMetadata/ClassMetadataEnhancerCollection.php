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

namespace WellCommerce\Bundle\CoreBundle\Enhancer\ClassMetadata;

use WellCommerce\Bundle\CoreBundle\Enhancer\MappingEnhancerInterface;
use WellCommerce\Component\Collections\ArrayCollection;

/**
 * Class ClassMetadataEnhancerCollection
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ClassMetadataEnhancerCollection extends ArrayCollection
{
    /**
     * @param MappingEnhancerInterface $enhancer
     */
    public function add(MappingEnhancerInterface $enhancer)
    {
        $this->items[$enhancer->getSupportedEntityClass()][] = $enhancer;
    }

    /**
     * Returns an array of enhancers for given class
     *
     * @param string $class
     *
     * @return MappingEnhancerInterface[]
     */
    public function get($class)
    {
        return $this->items[$class];
    }
}
