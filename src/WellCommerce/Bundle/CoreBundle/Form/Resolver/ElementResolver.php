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

namespace WellCommerce\Bundle\CoreBundle\Form\Resolver;

use Symfony\Component\DependencyInjection\ContainerAware;

/**
 * Class ElementResolver
 *
 * @package WellCommerce\Bundle\CoreBundle\Form\Resolver
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ElementResolver extends ContainerAware implements ElementResolverInterface
{
    /**
     * {@inheritdoc}
     */
    public function resolve($type)
    {
        $service = sprintf('form.element.%s', $type);
        if (!$this->container->has($service)) {
            throw new \InvalidArgumentException(sprintf('Tried to get %s which does not exists in container', $service));
        }

        return $this->container->get($service);
    }
} 