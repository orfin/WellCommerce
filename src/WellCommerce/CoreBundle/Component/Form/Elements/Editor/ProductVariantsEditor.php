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

namespace WellCommerce\CoreBundle\Component\Form\Elements\Editor;

use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use WellCommerce\CoreBundle\Component\Form\Elements\AbstractField;
use WellCommerce\CoreBundle\Component\Form\Elements\Attribute;
use WellCommerce\CoreBundle\Component\Form\Elements\AttributeCollection;
use WellCommerce\CoreBundle\Component\Form\Elements\ElementInterface;

/**
 * Class ProductVariantsEditor
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductVariantsEditor extends AbstractField implements ElementInterface
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setRequired([
            'set',
            'category_field',
            'price_field',
            'availability_field',
            'vat_field',
            'vat_values',
            'allow_generate',
            'suffixes',
            'get_groups_route',
            'get_attributes_route',
        ]);

        $resolver->setDefaults([
            'set'                         => null,
            'allow_generate'              => true,
            'suffixes'                    => ['+', '-', '%', '='],
            'photos'                      => [],
            'availability'                => [],
            'get_groups_route'            => 'admin.attribute_group.ajax.index',
            'get_attributes_route'        => 'admin.attribute.ajax.index',
            'get_attributes_values_route' => 'admin.attribute_value.ajax.index',
            'add_attribute_route'         => 'admin.attribute.ajax.add',
            'add_attribute_value_route'   => 'admin.attribute_value.ajax.add',
        ]);

        $resolver->setAllowedTypes([
            'allow_generate'     => 'bool',
            'availability_field' => 'WellCommerce\CoreBundle\Component\Form\Elements\ElementInterface',
            'vat_field'          => 'WellCommerce\CoreBundle\Component\Form\Elements\ElementInterface',
            'vat_values'         => 'array',
            'photos'             => 'array',
            'availability'       => 'array',
            'price_field'        => 'WellCommerce\CoreBundle\Component\Form\Elements\ElementInterface',
            'category_field'     => 'WellCommerce\CoreBundle\Component\Form\Elements\ElementInterface',
        ]);

        $fieldNormalizer = function (Options $options, $value) {
            if (!$value instanceof ElementInterface) {
                throw new \InvalidArgumentException('Passed field should implement "ElementInterface" and have accessible "getName" method.');
            }

            return $value->getName();
        };

        $resolver->setNormalizers([
            'vat_field'          => $fieldNormalizer,
            'price_field'        => $fieldNormalizer,
            'category_field'     => $fieldNormalizer,
            'availability_field' => $fieldNormalizer,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function prepareAttributesCollection(AttributeCollection $collection)
    {
        parent::prepareAttributesCollection($collection);
        $collection->add(new Attribute('sGetGroupsRoute', $this->getOption('get_groups_route')));
        $collection->add(new Attribute('sGetAttributesRoute', $this->getOption('get_attributes_route')));
        $collection->add(new Attribute('sGetAttributesValuesRoute', $this->getOption('get_attributes_values_route')));
        $collection->add(new Attribute('sAddAttributeRoute', $this->getOption('add_attribute_route')));
        $collection->add(new Attribute('sAddAttributeValueRoute', $this->getOption('add_attribute_value_route')));
        $collection->add(new Attribute('sCategoryField', $this->getOption('category_field')));
        $collection->add(new Attribute('sPriceField', $this->getOption('price_field')));
        $collection->add(new Attribute('bAllowGenerate', $this->getOption('allow_generate'), Attribute::TYPE_BOOLEAN));
        $collection->add(new Attribute('sVatField', $this->getOption('vat_field')));
        $collection->add(new Attribute('aoVatValues', $this->getOption('vat_values'), Attribute::TYPE_ARRAY));
        $collection->add(new Attribute('aoPhotos', $this->getOption('photos'), Attribute::TYPE_ARRAY));
        $collection->add(new Attribute('aoAvailability', $this->getOption('availability'), Attribute::TYPE_ARRAY));
        $collection->add(new Attribute('aoSuffixes', $this->getOption('suffixes'), Attribute::TYPE_ARRAY));
        $collection->add(new Attribute('sSet', $this->getOption('set')));
    }
}
