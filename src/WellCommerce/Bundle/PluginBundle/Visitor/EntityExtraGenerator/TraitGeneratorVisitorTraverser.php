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

use Zend\Code\Generator\TraitGenerator;

/**
 * Class OrderVisitorTraverser
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class TraitGeneratorVisitorTraverser implements TraitGeneratorVisitorTraverserInterface
{
    /**
     * @var TraitGeneratorVisitorCollection
     */
    protected $collection;

    /**
     * ClassMetadataVisitorTraverser constructor.
     *
     * @param TraitGeneratorVisitorCollection $collection
     */
    public function __construct(TraitGeneratorVisitorCollection $collection)
    {
        $this->collection = $collection;
    }

    /**
     * {@inheritdoc}
     */
    public function traverse($className, TraitGenerator $generator)
    {
        foreach ($this->collection->get($className) as $visitor) {
            $visitor->visit($generator);
        }
    }
}
