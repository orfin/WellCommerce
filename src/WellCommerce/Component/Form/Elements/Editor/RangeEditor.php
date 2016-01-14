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
 * Class RangeEditor
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class RangeEditor extends AbstractField implements ElementInterface
{
    const RANGE_PRECISION = 4;
    const PRICE_PRECISION = 4;

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setRequired([
            'price_precision',
            'range_precision',
            'range_suffix',
            'suffix',
        ]);

        $vatFieldName = function (Options $options) {
            if (isset($options['vat_field']) && $options['vat_field'] instanceof ElementInterface) {
                return $options['vat_field']->getName();
            }

            return;
        };

        $resolver->setDefaults([
            'vat_field'       => null,
            'suffix'          => '',
            'vat_field_name'  => $vatFieldName,
            'range_suffix'    => '',
            'range_precision' => self::RANGE_PRECISION,
            'price_precision' => self::PRICE_PRECISION,
            'options'         => [],
            'prefixes'        => ['net', 'gross'],
        ]);

        $resolver->setAllowedTypes('suffix', 'string');
        $resolver->setAllowedTypes('price_precision', 'int');
        $resolver->setAllowedTypes('range_precision', 'int');
        $resolver->setAllowedTypes('range_suffix', 'string');
        $resolver->setAllowedTypes('vat_field', ['null', ElementInterface::class]);
        $resolver->setAllowedTypes('vat_field_name', 'string');
        $resolver->setAllowedTypes('prefixes', 'array');
    }

    /**
     * {@inheritdoc}
     */
    public function prepareAttributesCollection(AttributeCollection $collection)
    {
        parent::prepareAttributesCollection($collection);
        $collection->add(new Attribute('sSuffix', $this->getOption('suffix')));
        $collection->add(new Attribute('iPricePrecision', $this->getOption('price_precision'), Attribute::TYPE_INTEGER));
        $collection->add(new Attribute('iRangePrecision', $this->getOption('range_precision'), Attribute::TYPE_INTEGER));
        $collection->add(new Attribute('sRangeSuffix', $this->getOption('range_suffix')));
        $collection->add(new Attribute('asPrefixes', $this->getOption('prefixes'), Attribute::TYPE_ARRAY));
        $collection->add(new Attribute('sVatField', $this->getOption('vat_field_name')));
    }
}
