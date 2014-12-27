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

/**
 * Class TextField
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class SlugField extends TextField implements ElementInterface
{
    /**
     * {@inheritdoc}
     */
    public function configureAttributes(OptionsResolver $resolver)
    {
        parent::configureAttributes($resolver);

        $resolver->setRequired([
            'translatable_id',
            'name_field',
            'generate_route',
            'class'
        ]);

        $resolver->setDefaults([
            'class' => 'sluggable'
        ]);

        $resolver->setAllowedTypes([
            'name_field'     => 'WellCommerce\Bundle\CoreBundle\Form\Elements\ElementInterface',
            'generate_route' => 'string'
        ]);

        $fieldNormalizer = function (Options $options, $value) {
            if (!$value instanceof ElementInterface) {
                throw new \InvalidArgumentException('Passed field should implement "ElementInterface" and have accessible "getName" method.');
            }

            return $value->getName();
        };

        $resolver->setNormalizers([
            'name_field' => $fieldNormalizer
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
            $this->formatAttributeJs('comment', 'sComment'),
            $this->formatAttributeJs('suffix', 'sSuffix'),
            $this->formatAttributeJs('prefix', 'sPrefix'),
            $this->formatAttributeJs('selector', 'sSelector'),
            $this->formatAttributeJs('wrap', 'sWrapClass'),
            $this->formatAttributeJs('class', 'sClass'),
            $this->formatAttributeJs('translatable_id', 'sTranslatableId'),
            $this->formatAttributeJs('name_field', 'sNameField'),
            $this->formatAttributeJs('generate_route', 'sGenerateRoute'),
            $this->formatAttributeJs('css_attribute', 'sCssAttribute'),
            $this->formatAttributeJs('max_length', 'iMaxLength'),
            $this->formatAttributeJs('error', 'sError'),
            $this->formatRulesJs(),
            $this->formatDependencyJs(),
        ];
    }
}
