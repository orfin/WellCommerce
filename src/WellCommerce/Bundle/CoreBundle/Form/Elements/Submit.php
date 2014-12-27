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

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class Submit
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Submit extends AbstractNode implements ElementInterface
{
    /**
     * {@inheritdoc}
     */
    public function configureAttributes(OptionsResolver $resolver)
    {
        $resolver->setRequired([
            'name',
            'label'
        ]);

        $resolver->setDefined([
            'class',
            'icon'
        ]);

        $resolver->setAllowedTypes([
            'name'  => 'string',
            'class' => 'string',
            'label' => 'string',
            'icon'  => 'icon'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function prepareAttributesJs()
    {
        $attributes = [
            $this->formatAttributeJs('name', 'sName'),
            $this->formatAttributeJs('class', 'sClass'),
            $this->formatAttributeJs('label', 'sLabel'),
            $this->formatAttributeJs('icon', 'sIcon'),
            $this->formatDependencyJs()
        ];

        return $attributes;
    }

    /**
     * {@inheritdoc}
     */
    public function getValue()
    {
        return '';
    }

    /**
     * {@inheritdoc}
     */
    public function populate($value)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function setPropertyPath()
    {
        $this->attributes['property_path'] = null;
    }

    /**
     * {@inheritdoc}
     */
    public function handleRequest($data)
    {
        return null;
    }
}
