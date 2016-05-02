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

namespace WellCommerce\Bundle\RoutingBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class RegisterRoutingDiscriminatorsPass
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class RegisterRoutingDiscriminatorsPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        foreach ($container->getExtensions() as $extension) {
            $parameterName = $extension->getAlias() . '.routing_discriminator.map';
            if ($container->hasParameter($parameterName)) {
                $this->processParameters($container->getParameter($parameterName), $container);
            }
        }
    }

    private function processParameters(array $parameters, ContainerBuilder $container)
    {
        $map = $container->getParameter('routing_discriminator_map');
        foreach ($parameters as $discriminatorName => $discriminatorClass) {
            $map[$discriminatorName] = $discriminatorClass;
        }

        $container->setParameter('routing_discriminator_map', $map);
    }
}
