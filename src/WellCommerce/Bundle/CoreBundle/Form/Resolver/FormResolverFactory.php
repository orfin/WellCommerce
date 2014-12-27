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
     * {@inheritdoc}
     */
    public function addResolver($type, ResolverInterface $resolver)
    {
        $this->resolvers[$type] = $resolver;
    }

    /**
     * {@inheritdoc}
     */
    public function hasResolver($type)
    {
        return isset($this->resolvers[$type]);
    }

    /**
     * {@inheritdoc}
     */
    public function getResolver($type)
    {
        return $this->resolvers[$type];
    }

    /**
     * {@inheritdoc}
     */
    public function resolve($type, $alias)
    {
        if (!$this->hasResolver($type)) {
            throw new \InvalidArgumentException(sprintf('No matching resolver found for "%s"', $type));
        }

        return $this->getResolver($type)->get($alias);
    }
} 