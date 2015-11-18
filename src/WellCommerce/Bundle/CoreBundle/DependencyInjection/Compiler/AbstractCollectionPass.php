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

namespace WellCommerce\Bundle\CoreBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class AbstractCollectionPass
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractCollectionPass implements CompilerPassInterface
{
    /**
     * @var string
     */
    protected $collectionServiceId;

    /**
     * @var string
     */
    protected $serviceTag;

    /**
     * Processes the container
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition($this->collectionServiceId)) {
            return;
        }

        $collection = $this->getCollection($container);

        foreach ($container->findTaggedServiceIds($this->serviceTag) as $id => $attributes) {
            $this->addServiceToCollection($collection, $id);
        }
    }

    /**
     * Returns collection service definition
     *
     * @param ContainerBuilder $container
     *
     * @return \Symfony\Component\DependencyInjection\Definition
     */
    protected function getCollection(ContainerBuilder $container)
    {
        return $container->getDefinition($this->collectionServiceId);
    }

    /**
     * Adds new tagged service to collection
     *
     * @param Definition $collection
     * @param string     $id
     */
    protected function addServiceToCollection(Definition $collection, $id)
    {
        $collection->addMethodCall('add', [
            new Reference($id)
        ]);
    }
}
