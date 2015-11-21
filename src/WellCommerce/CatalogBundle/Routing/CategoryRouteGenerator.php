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

namespace WellCommerce\CatalogBundle\Routing;

use Symfony\Component\Routing\Route as SymfonyRoute;
use WellCommerce\CommonBundle\Entity\RouteInterface;
use WellCommerce\CommonBundle\Generator\AbstractRouteGenerator;

/**
 * Class CategoryRouteGenerator
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CategoryRouteGenerator extends AbstractRouteGenerator
{
    const GENERATOR_STRATEGY = 'category';

    public function generate(RouteInterface $resource)
    {
        $this->defaults['id']      = $resource->getIdentifier()->getId();
        $this->defaults['_locale'] = $resource->getLocale();

        return new SymfonyRoute(
            $this->getPath($resource),
            $this->defaults,
            $this->requirements,
            $this->options
        );
    }

    /**
     * {@inheritdoc}
     */
    public function supports($strategy)
    {
        return self::GENERATOR_STRATEGY === $strategy;
    }
}
