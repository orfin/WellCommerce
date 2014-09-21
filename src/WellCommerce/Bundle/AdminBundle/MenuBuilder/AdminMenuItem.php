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

namespace WellCommerce\Bundle\AdminBundle\MenuBuilder;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class AdminMenuItem
 *
 * @package WellCommerce\Bundle\AdminBundle\MenuBuilder
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AdminMenuItem implements AdminMenuItemInterface, \ArrayAccess
{
    /**
     * @var array Item options
     */
    public $options = [];

    /**
     * @var array Item children
     */
    public $children = [];

    /**
     * Constructor
     *
     * @param array $options Menu item options
     */
    public function __construct(array $options)
    {
        $resolver = new OptionsResolver();
        $this->configureOptions($resolver);

        $this->options = $resolver->resolve($options);
    }

    /**
     * Configures admin menu item options
     *
     * @param OptionsResolverInterface $resolver
     */
    public function configureOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired([
            'id',
            'name',
            'link',
            'path'
        ]);

        $resolver->setOptional([
            'class',
            'sort_order',
        ]);

        $resolver->setDefaults(array(
            'sort_order' => 0,
            'class'      => '',
            'link'       => ''
        ));

        $resolver->setAllowedTypes(array(
            'id'         => 'string',
            'name'       => 'string',
            'link'       => 'string',
            'class'      => 'string',
            'sort_order' => 'integer',
        ));

    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->options['id'];
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->options['name'];
    }

    /**
     * {@inheritdoc}
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * {@inheritdoc}
     */
    public function getClass()
    {
        return $this->options['class'];
    }

    /**
     * {@inheritdoc}
     */
    public function getLink()
    {
        return $this->options['link'];
    }

    /**
     * {@inheritdoc}
     */
    public function getSortOrder()
    {
        return $this->options['sort_order'];
    }

    /**
     * {@inheritdoc}
     */
    public function getPath()
    {
        return $this->options['path'];
    }

    /**
     * {@inheritdoc}
     */
    public function sortChildren()
    {
        usort($this->children, function (AdminMenuItem $a, AdminMenuItem $b) {
            if ($a->getSortOrder() == $b->getSortOrder()) {
                return 0;
            }

            return $a->getSortOrder() > $b->getSortOrder() ? 1 : -1;
        });
    }

    /**
     * {@inheritdoc}
     */
    public function offsetExists($offset)
    {
        return isset($this->children[$offset]);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($offset, $value)
    {
        $this->children[$offset] = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function offsetGet($offset)
    {
        return $this->children[$offset];
    }

    /**
     * {@inheritdoc}
     */
    public function offsetUnset($offset)
    {
        unset($this->children[$offset]);
    }
} 