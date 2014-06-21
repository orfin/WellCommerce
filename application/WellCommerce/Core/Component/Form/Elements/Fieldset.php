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

namespace WellCommerce\Core\Component\Form\Elements;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class Fieldset
 *
 * @package WellCommerce\Core\Component\Form\Elements
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Fieldset extends Container implements ElementInterface
{
    /**
     * {@inheritdoc}
     */
    public function configureAttributes(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired([
            'name',
        ]);

        $resolver->setOptional([
            'label',
            'class',
            'repeat_min',
            'repeat_max',
            'dependencies',
        ]);

        $resolver->setAllowedTypes([
            'name'         => ['int', 'string'],
            'label'        => 'string',
            'class'        => 'string',
            'repeat_min'   => ['int', 'string'],
            'repeat_max'   => ['int', 'string'],
            'dependencies' => 'array',
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
            $this->formatAttributeJs('class', 'sClass'),
            $this->formatDependencyJs(),
            'aoFields: [' . $this->renderChildren() . ']'
        ];

        return $attributes;
    }

}
