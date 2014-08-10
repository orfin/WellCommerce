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
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class FieldsetLanguage
 *
 * @package WellCommerce\Bundle\CoreBundle\Form\Elements
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class FieldsetLanguage extends Fieldset implements ElementInterface
{
    /**
     * {@inheritdoc}
     */
    public function configureAttributes(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired([
            'name',
            'languages'
        ]);

        $resolver->setOptional([
            'class',
            'label',
            'repeat_min',
            'repeat_max',
            'property_path',
            'dependencies',
            'filters',
            'rules',
        ]);

        $resolver->setDefaults([
            'property_path' => null,
            'dependencies'  => [],
            'filters'       => [],
            'rules'         => [],
            'repeat_min' => function (Options $options) {
                    return count($options['languages']);
                },
            'repeat_max' => function (Options $options) {
                    return count($options['languages']);
                },
        ]);

        $resolver->setAllowedTypes([
            'name'       => 'string',
            'label'      => 'string',
            'class'      => 'string',
            'languages'  => 'array',
            'repeat_min' => 'integer',
            'repeat_max' => 'integer',
        ]);
    }

    protected function formatLanguagesJs()
    {
        $options = [];
        foreach ($this->languages as $language) {
            $value     = addslashes($language['id']);
            $label     = addslashes($language['translation']);
            $flag      = addslashes(sprintf('%s.png', substr($language['name'], 0, 2)));
            $options[] = "{sValue: '{$value}', sLabel: '{$label}',sFlag: '{$flag}' }";
        }

        return 'aoLanguages: [' . implode(', ', $options) . ']';
    }

    /**
     * {@inheritdoc}
     */
    public function prepareAttributesJs()
    {
        $attributes = [
            $this->formatAttributeJs('name', 'sName'),
            $this->formatAttributeJs('label', 'sLabel'),
            $this->formatRepeatableJs(),
            $this->formatDependencyJs(),
            $this->formatLanguagesJs(),
            'aoFields: [' . $this->renderChildren() . ']'
        ];

        return $attributes;
    }

}
