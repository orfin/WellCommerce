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

namespace WellCommerce\Bundle\CoreBundle\Form\Elements;

use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\PropertyAccess\PropertyPath;

/**
 * Class TextField
 *
 * @package WellCommerce\Bundle\CoreBundle\Form\Elements
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class TextField extends Field implements ElementInterface
{
    const SIZE_SHORT  = 'short';
    const SIZE_MEDIUM = 'medium';
    const SIZE_LONG   = 'long';

    /**
     * {@inheritdoc}
     */
    public function configureAttributes(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired([
            'name',
            'label'
        ]);

        $resolver->setOptional([
            'comment',
            'suffix',
            'prefix',
            'selector',
            'wrap',
            'class',
            'css_attribute',
            'max_length',
            'error',
            'filters',
            'dependencies',
            'rules',
            'filters',
            'default',
            'property_path'
        ]);

        $resolver->setDefaults([
            'dependencies'  => [],
            'filters'       => [],
            'rules'         => [],
            'property_path' => function (Options $options) {
                    return new PropertyPath($options['name']);
                },
        ]);

        $resolver->setAllowedTypes([
            'name'          => 'string',
            'label'         => 'string',
            'comment'       => 'string',
            'suffix'        => 'string',
            'prefix'        => 'string',
            'selector'      => 'string',
            'wrap'          => 'string',
            'class'         => 'string',
            'css_attribute' => 'string',
            'max_length'    => 'integer',
            'error'         => 'string',
            'filters'       => 'array',
            'rules'         => 'array',
            'dependencies'  => 'array',
            'default'       => ['string', 'integer']
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function prepareAttributesJs()
    {
        $attributes = [
            $this->formatAttributeJs('name', 'sName'),
            $this->formatAttributeJs('label', 'sLabel'),
            $this->formatAttributeJs('comment', 'sComment'),
            $this->formatAttributeJs('suffix', 'sSuffix'),
            $this->formatAttributeJs('prefix', 'sPrefix'),
            $this->formatAttributeJs('selector', 'sSelector'),
            $this->formatAttributeJs('wrap', 'sWrapClass'),
            $this->formatAttributeJs('class', 'sClass'),
            $this->formatAttributeJs('css_attribute', 'sCssAttribute'),
            $this->formatAttributeJs('max_length', 'iMaxLength'),
            $this->formatAttributeJs('error', 'sError'),
            $this->formatRepeatableJs(),
            $this->formatRulesJs(),
            $this->formatDependencyJs(),
            $this->formatDefaultsJs()
        ];

        return $attributes;
    }
}
