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

namespace WellCommerce\Bundle\CoreBundle\Form;

use WellCommerce\Bundle\CoreBundle\Form\Resolver\ResolverInterface;

/**
 * Class FormResolverFactory
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class FormResolverFactory implements FormResolverFactoryInterface
{
    /**
     * @var array
     */
    protected $resolvers;

    /**
     * Adds new resolver to stack
     *
     * @param                   $type
     * @param ResolverInterface $resolver
     */
    public function addResolver($type, ResolverInterface $resolver)
    {
        $this->resolvers[$type] = $resolver;
    }

    /**
     * Checks whether resolver is available
     *
     * @param $type
     *
     * @return bool
     */
    protected function hasResolver($type)
    {
        return isset($this->resolvers[$type]);
    }

    /**
     * Returns resolver instance by type
     *
     * @param $type
     *
     * @return ResolverInterface
     */
    protected function getResolver($type)
    {
        return $this->resolvers[$type];
    }

    public function resolve($type, $alias)
    {
        if (!$this->hasResolver($type)) {
            throw new \InvalidArgumentException(sprintf('No matching resolver found for "%s"', $type));
        }

        return $this->getResolver($type)->get($alias);
    }
} 