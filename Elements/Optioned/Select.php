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

namespace WellCommerce\Component\Form\Elements\Optioned;

use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use WellCommerce\Component\Form\Elements\Attribute;
use WellCommerce\Component\Form\Elements\AttributeCollection;

/**
 * Class Select
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Select extends AbstractOptionedField implements OptionedFieldInterface
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'addable'         => false,
            'onAdd'           => '',
            'add_item_prompt' => '',
            'selector'        => '',
            'css_attribute'   => '',
        ]);

        $resolver->setDefault('default', function (Options $options) {
            if (count($options['options'])) {
                return current(array_keys($options['options']));
            }

            return null;
        });

        $resolver->setAllowedTypes('selector', 'string');
        $resolver->setAllowedTypes('css_attribute', 'string');
        $resolver->setAllowedTypes('addable', 'bool');
        $resolver->setAllowedTypes('onAdd', 'string');
        $resolver->setAllowedTypes('add_item_prompt', 'string');
    }

    /**
     * {@inheritdoc}
     */
    public function prepareAttributesCollection(AttributeCollection $collection)
    {
        parent::prepareAttributesCollection($collection);
        $collection->add(new Attribute('bAddable', $this->getOption('addable'), Attribute::TYPE_BOOLEAN));
        $collection->add(new Attribute('fOnAdd', $this->getOption('onAdd'), Attribute::TYPE_FUNCTION));
        $collection->add(new Attribute('sAddItemPrompt', $this->getOption('add_item_prompt')));
        $collection->add(new Attribute('sSelector', $this->getOption('selector')));
        $collection->add(new Attribute('sCssAttribute', $this->getOption('css_attribute')));
    }
}
