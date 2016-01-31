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

use WellCommerce\Component\Collections\ArrayCollection;

/**
 * Class ClassMetadataVisitorCollection
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ClassMetadataVisitorCollection extends ArrayCollection
{
    /**
     * @param ClassMetadataVisitorInterface $visitor
     */
    public function add(ClassMetadataVisitorInterface $visitor)
    {
        $this->items[$visitor->getSupportedClass()][] = $visitor;
    }

    /**
     * Returns an array of visitors for given class
     *
     * @param string $class
     *
     * @return ClassMetadataVisitorInterface[]
     */
    public function get($class)
    {
        return $this->items[$class];
    }
}
