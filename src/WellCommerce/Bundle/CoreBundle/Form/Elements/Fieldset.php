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
 * Class Fieldset
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Fieldset extends AbstractContainer implements ElementInterface
{
    /**
     * {@inheritdoc}
     */
    public function configureAttributes(OptionsResolver $resolver)
    {
        $resolver->setRequired([
            'name',
        ]);

        $resolver->setDefined([
            'label',
            'class',
            'property_path',
            'dependencies',
            'filters',
            'rules',
            'transformer'
        ]);

        $resolver->setDefaults([
            'property_path' => null,
            'dependencies'  => [],
            'filters'       => [],
            'rules'         => [],
            'transformer'   => null
        ]);

        $resolver->setAllowedTypes([
            'name'          => ['int', 'string'],
            'label'         => 'string',
            'class'         => 'string',
            'dependencies'  => 'array',
            'property_path' => ['null', 'Symfony\Component\PropertyAccess\PropertyPath'],
            'transformer'   => ['null', 'WellCommerce\Bundle\CoreBundle\Form\DataTransformer\DataTransformerInterface'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function prepareAttributesJs()
    {
        return [
            $this->formatAttributeJs('name', 'sName'),
            $this->formatAttributeJs('label', 'sLabel'),
            $this->formatAttributeJs('class', 'sClass'),
            $this->formatDependencyJs(),
            'aoFields: [' . $this->renderChildren() . ']'
        ];
    }


    protected function formatRepeatableJs()
    {
        $min = $this->attributes['repeat_min'];
        $max = $this->attributes['repeat_max'];

        return "oRepeat: {iMin: {$min}, iMax: {$max}}";

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
    public function getValue()
    {
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function handleRequest($data)
    {
        return null;
    }
}
