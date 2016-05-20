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

namespace WellCommerce\Component\Breadcrumb\Model;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class Breadcrumb
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class Breadcrumb implements BreadcrumbInterface
{
    /**
     * @var array Item options
     */
    private $options = [];

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

    public function getLabel() : string
    {
        return $this->options['label'];
    }

    public function getCssClass() : string
    {
        return $this->options['css_class'];
    }

    public function getUrl() : string
    {
        return $this->options['url'];
    }

    private function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired([
            'label',
            'url',
            'css_class',
        ]);

        $resolver->setDefaults([
            'css_class' => '',
            'url'       => ''
        ]);

        $resolver->setAllowedTypes('label', 'string');
        $resolver->setAllowedTypes('url', 'string');
        $resolver->setAllowedTypes('css_class', 'string');
    }
}
