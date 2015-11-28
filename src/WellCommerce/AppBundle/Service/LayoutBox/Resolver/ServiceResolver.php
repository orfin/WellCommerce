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

namespace WellCommerce\AppBundle\Service\LayoutBox\Resolver;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;
use WellCommerce\AppBundle\Entity\LayoutBoxInterface;
use WellCommerce\AppBundle\Service\LayoutBox\Configurator\LayoutBoxConfiguratorCollection;

/**
 * Class ServiceResolver
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ServiceResolver extends ContainerAware implements ServiceResolverInterface
{
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
