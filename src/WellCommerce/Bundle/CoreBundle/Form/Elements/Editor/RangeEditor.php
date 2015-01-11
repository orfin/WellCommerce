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

namespace WellCommerce\Bundle\CoreBundle\Form\Elements\Editor;

use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use WellCommerce\Bundle\CoreBundle\Form\Elements\AbstractField;
use WellCommerce\Bundle\CoreBundle\Form\Elements\Attribute;
use WellCommerce\Bundle\CoreBundle\Form\Elements\AttributeCollection;
use WellCommerce\Bundle\CoreBundle\Form\Elements\ElementInterface;

/**
 * Class RangeEditor
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class RangeEditor extends AbstractField implements ElementInterface
{
    const RANGE_PRECISION = 2;
    const PRICE_PRECISION = 2;

    /**
     * {@inheritdoc}
     */
    public function configureAttributes(OptionsResolver $resolver)
    {
        $resolver->setRequired([
            'price_precision',
            'range_precision',
            'range_suffix',
            'prefixes',
            'allow_vat',
            'vat_values',
        ]);

        $vatValues = function (Options $options) {
            if (isset($options['allow_vat']) && !$options['allow_vat']) {
                return [];
            }

            return $options['vat_values'];
        };

        $resolver->setDefaults([
            'range_precision' => self::RANGE_PRECISION,
            'price_precision' => self::PRICE_PRECISION,
            'options'         => [],
            'vat_values'      => $vatValues,
        ]);

        $resolver->setAllowedTypes([
            'suffix'          => 'string',
            'price_precision' => 'int',
            'range_precision' => 'int',
            'range_suffix'    => 'string',
            'prefixes'        => 'array',
            'allow_vat'       => 'bool',
            'vat_values'      => 'array',
        ]);
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
        $collection->add(new Attribute('bAllowVat', $this->getOption('allow_vat'), Attribute::TYPE_BOOLEAN));
        $collection->add(new Attribute('aoVatValues', $this->getOption('vat_values'), Attribute::TYPE_ARRAY));
    }
}
