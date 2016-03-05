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
use Symfony\Component\DependencyInjection\Reference;
use WellCommerce\Component\DataSet\Transformer\DataSetTransformerInterface;

/**
 * Class DataSetTransformerPass
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class DataSetTransformerPass implements CompilerPassInterface
{
    /**
     * Processes the container
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        $tag        = 'dataset.transformer';
        $interface  = DataSetTransformerInterface::class;
        $definition = $container->getDefinition('dataset.transformer.collection');

        foreach ($container->findTaggedServiceIds($tag) as $id => $attributes) {
            $itemDefinition = $container->getDefinition($id);
            $refClass       = new \ReflectionClass($itemDefinition->getClass());

            if (!$refClass->implementsInterface($interface)) {
                throw new \InvalidArgumentException(
                    sprintf('DataSetTransformer "%s" tagged with "%s" must implement interface "%s".', $id, $tag, $interface)
                );
            }

            $definition->addMethodCall('add', [
                $attributes[0]['alias'],
                new Reference($id)
            ]);
        }
    }
}
