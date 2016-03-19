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

namespace WellCommerce\Component\Form\Elements\Editor;

use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use WellCommerce\Component\Form\Elements\AbstractField;
use WellCommerce\Component\Form\Elements\Attribute;
use WellCommerce\Component\Form\Elements\AttributeCollection;
use WellCommerce\Component\Form\Elements\ElementInterface;

/**
 * Class PriceEditor
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class PriceEditor extends AbstractField implements ElementInterface
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setRequired([
            'prefixes',
            'vat_field',
            'vat_field_name',
            'vat_values',
            'suffix',
        ]);

        $vatFieldName = function (Options $options) {
            if (isset($options['vat_field']) && $options['vat_field'] instanceof ElementInterface) {
                return $options['vat_field']->getName();
            }

            return null;
        };

        $vatValues = function (Options $options) {
            if (isset($options['vat_field']) && $options['vat_field'] instanceof ElementInterface) {
                return $options['vat_field']->getOption('options');
            }

            return [];
        };

        $resolver->setDefaults([
            'prefixes'       => ['net', 'gross'],
            'vat_field'      => null,
            'suffix'         => '',
            'vat_field_name' => $vatFieldName,
            'vat_values'     => $vatValues,
        ]);

        $resolver->setAllowedTypes('suffix', 'string');
        $resolver->setAllowedTypes('prefixes', 'array');
        $resolver->setAllowedTypes('vat_values', 'array');
        $resolver->setAllowedTypes('vat_field', ['null', ElementInterface::class]);
        $resolver->setAllowedTypes('vat_field_name', 'string');
    }

    /**
     * {@inheritdoc}
     */
    public function prepareAttributesCollection(AttributeCollection $collection)
    {
        parent::prepareAttributesCollection($collection);
        $collection->add(new Attribute('sSuffix', $this->getOption('suffix')));
        $collection->add(new Attribute('asPrefixes', $this->getOption('prefixes'), Attribute::TYPE_ARRAY));
        $collection->add(new Attribute('aoVatValues', $this->getOption('vat_values'), Attribute::TYPE_ARRAY));
        $collection->add(new Attribute('sVatField', $this->getOption('vat_field_name')));
    }
}
