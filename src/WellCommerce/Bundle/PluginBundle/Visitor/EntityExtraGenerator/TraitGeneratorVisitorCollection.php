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

namespace WellCommerce\Bundle\PluginBundle\Visitor\EntityExtraGenerator;

use WellCommerce\Component\Collections\ArrayCollection;

/**
 * Class TraitGeneratorVisitorCollection
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class TraitGeneratorVisitorCollection extends ArrayCollection
{
    /**
     * @param TraitGeneratorVisitorInterface $visitor
     */
    public function add(TraitGeneratorVisitorInterface $visitor)
    {
        $this->items[$visitor->getSupportedClass()][] = $visitor;
    }

    /**
     * @return TraitGeneratorVisitorInterface[]
     */
    public function all()
    {
        return $this->items;
    }

    /**
     * Returns an array of visitors for given class
     *
     * @param string $class
     *
     * @return TraitGeneratorVisitorInterface[]
     */
    public function get($class)
    {
        return $this->items[$class];
    }
}
