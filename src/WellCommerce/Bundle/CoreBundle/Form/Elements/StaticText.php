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
 * Class StaticText
 *
 * @package WellCommerce\Bundle\CoreBundle\Form\Elements
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class StaticText extends AbstractNode implements ElementInterface
{
    /**
     * {@inheritdoc}
     */
    public function configureAttributes(OptionsResolver $resolver)
    {
        $resolver->setRequired([
            'text',
        ]);

        $resolver->setDefined([
            'class',
            'name',
        ]);

        $resolver->setDefaults([
            'name' => ''
        ]);

        $resolver->setAllowedTypes([
            'text'  => 'string',
            'class' => 'string',
        ]);
    }

    public function prepareAttributesJs()
    {
        return [
            $this->formatAttributeJs('text', 'sText'),
            $this->formatAttributeJs('class', 'sClass'),
            $this->formatDependencyJs()
        ];
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
