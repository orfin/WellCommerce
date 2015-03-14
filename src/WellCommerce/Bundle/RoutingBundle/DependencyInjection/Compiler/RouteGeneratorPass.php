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
use WellCommerce\Bundle\CoreBundle\DependencyInjection\Compiler\AbstractCollectionPass;

/**
 * Class RouteGeneratorPass
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class RouteGeneratorPass extends AbstractCollectionPass implements CompilerPassInterface
{
    /**
     * @var string
     */
    protected $collectionServiceId = 'route.generator.collection';

    /**
     * @var string
     */
    protected $serviceTag = 'route.generator';
}
