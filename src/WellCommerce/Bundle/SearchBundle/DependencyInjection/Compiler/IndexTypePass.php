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

namespace WellCommerce\Bundle\SearchBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use WellCommerce\Bundle\SearchBundle\Type\IndexTypeInterface;

/**
 * Class IndexTypePass
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class IndexTypePass implements CompilerPassInterface
{
    /**
     * Processes the container
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        $tag                            = 'search.index_type';
        $interface                      = IndexTypeInterface::class;
        $typeCollectionDefinition       = $container->getDefinition('search.index_type.collection');

        foreach ($container->findTaggedServiceIds($tag) as $id => $attributes) {
            $itemDefinition = $container->getDefinition($id);
            $refClass       = new \ReflectionClass($itemDefinition->getClass());

            if (!$refClass->implementsInterface($interface)) {
                throw new \InvalidArgumentException(
                    sprintf('Index type "%s" tagged with "%s" must implement interface "%s".', $id, $tag, $interface)
                );
            }

            $typeCollectionDefinition->addMethodCall('set', [
                $attributes[0]['type'],
                new Reference($id)
            ]);
        }
    }
}
