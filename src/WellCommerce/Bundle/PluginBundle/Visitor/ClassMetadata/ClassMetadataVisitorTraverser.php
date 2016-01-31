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
 * Class ClassMetadataVisitorTraverser
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ClassMetadataVisitorTraverser implements ClassMetadataVisitorTraverserInterface
{
    /**
     * @var ClassMetadataVisitorCollection
     */
    protected $collection;

    /**
     * ClassMetadataVisitorTraverser constructor.
     *
     * @param ClassMetadataVisitorCollection $collection
     */
    public function __construct(ClassMetadataVisitorCollection $collection)
    {
        $this->collection = $collection;
    }

    /**
     * {@inheritdoc}
     */
    public function traverse(ClassMetadataInfo $metadata)
    {
        $class = $metadata->getName();

        if (false === $this->collection->has($class)) {
            return false;
        }

        foreach ($this->collection->get($class) as $visitor) {
            $visitor->visit($metadata);
        }
    }
}
