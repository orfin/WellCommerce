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
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;

/**
 * Class AbstractResolver
 *
 * @package WellCommerce\Bundle\CoreBundle\Form\Resolver
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractResolver extends ContainerAware implements ResolverInterface
{
    /**
     * {@inheritdoc}
     */
    public function guess($type)
    {
        $id = sprintf($this->getServiceNamePattern(), $type);

        if (!$this->container->has($id)) {
            throw new ServiceNotFoundException($id);
        }

        return $id;
    }
}