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

namespace WellCommerce\Bundle\CoreBundle\Service\Breadcrumb;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class BreadcrumbItem
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class BreadcrumbItem implements BreadcrumbItemInterface
{
    /**
     * @var array Item options
     */
    protected $options = [];

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
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired([
            'name',
            'link',
            'class',
        ]);

        $resolver->setDefaults([
            'class' => '',
            'link'  => ''
        ]);

        $resolver->setAllowedTypes('name', 'string');
        $resolver->setAllowedTypes('link', 'string');
        $resolver->setAllowedTypes('class', 'string');
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
}
