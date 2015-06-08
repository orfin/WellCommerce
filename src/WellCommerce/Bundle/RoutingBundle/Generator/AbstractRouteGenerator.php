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

namespace WellCommerce\Bundle\RoutingBundle\Generator;

use Symfony\Component\Routing\Route as SymfonyRoute;
use WellCommerce\Bundle\RoutingBundle\Entity\RouteInterface;

/**
 * Class AbstractRouteGenerator
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractRouteGenerator implements RouteGeneratorInterface
{
    /**
     * @var array
     */
    protected $defaults;

    /**
     * @var array
     */
    protected $options;

    /**
     * @var array
     */
    protected $requirements;

    /**
     * Constructor
     *
     * @param array  $defaults
     * @param array  $options
     * @param array  $requirements
     */
    public function __construct(array $defaults = [], array $options = [], array $requirements = [])
    {
        $this->defaults     = $defaults;
        $this->options      = $options;
        $this->requirements = $requirements;
    }

    /**
     * {@inheritdoc}
     */
    public function generate(RouteInterface $resource)
    {
        $this->defaults['id']      = $resource->getIdentifier();
        $this->defaults['_locale'] = $resource->getLocale();

        return new SymfonyRoute(
            $resource->getPath(),
            $this->defaults,
            $this->requirements,
            $this->options
        );
    }

    /**
     * {@inheritdoc}
     */
    abstract public function supports($strategy);
}
