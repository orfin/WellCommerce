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

namespace WellCommerce\Bundle\LayoutBundle\Resolver;

use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;
use WellCommerce\Bundle\LayoutBundle\Configurator\LayoutBoxConfiguratorCollection;
use WellCommerce\Bundle\LayoutBundle\Entity\LayoutBoxInterface;

/**
 * Class ServiceResolver
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ServiceResolver implements ServiceResolverInterface
{
    use ContainerAwareTrait;

    /**
     * @var LayoutBoxConfiguratorCollection
     */
    protected $layoutBoxConfiguratorCollection;

    /**
     * Constructor
     *
     * @param LayoutBoxConfiguratorCollection $layoutBoxConfiguratorCollection
     */
    public function __construct(LayoutBoxConfiguratorCollection $layoutBoxConfiguratorCollection)
    {
        $this->layoutBoxConfiguratorCollection = $layoutBoxConfiguratorCollection;
    }

    /**
     * {@inheritdoc}
     */
    public function resolveControllerService(LayoutBoxInterface $layoutBox)
    {
        $boxType      = $layoutBox->getBoxType();
        $configurator = $this->layoutBoxConfiguratorCollection->get($boxType);
        $service      = $configurator->getControllerService();

        if (!$this->container->has($service)) {
            throw new ServiceNotFoundException($service);
        }

        return $this->container->get($service);
    }
}
