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
 * Class ProductVariantsEditor
 *
 * @package WellCommerce\Bundle\CoreBundle\Form\Elements
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductVariantsEditor extends AbstractField implements ElementInterface
{
    /**
     * {@inheritdoc}
     */
    public function configureAttributes(OptionsResolverInterface $resolver)
    {
        parent::configureAttributes($resolver);

        $resolver->setRequired([
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
            'allow_generate'              => true,
            'suffixes'                    => ['+', '-', '%', '='],
            'get_groups_route'            => 'admin.attribute_group.ajax.index',
            'get_attributes_route'        => 'admin.attribute.ajax.index',
            'get_attributes_values_route' => 'admin.attribute_value.ajax.index',
            'add_attribute_route'         => 'admin.attribute.ajax.add',
            'add_attribute_value_route'   => 'admin.attribute_value.ajax.add',
        ]);

        $resolver->setAllowedTypes([
            'allow_generate'     => ['bool'],
            'availability_field' => ['string'],
            'vat_field'          => ['string'],
            'vat_values'         => ['array'],
            'price_field'        => ['string'],
            'category_field'     => ['string'],
        ]);

        $fieldNormalizer = function (Options $options, $value) {
            if (!$value instanceof ElementInterface) {
                throw new \InvalidArgumentException('Passed field should implement "ElementInterface" and have accessible "getName" method.');
            }

            return $value->getName();
        };

        $resolver->setNormalizers(array(
            'vat_field'          => $fieldNormalizer,
            'price_field'        => $fieldNormalizer,
            'category_field'     => $fieldNormalizer,
            'availability_field' => $fieldNormalizer,
        ));
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
            $this->formatAttributeJs('error', 'sError'),
            $this->formatAttributeJs('get_groups_route', 'sGetGroupsRoute'),
            $this->formatAttributeJs('get_attributes_route', 'sGetAttributesRoute'),
            $this->formatAttributeJs('get_attributes_values_route', 'sGetAttributesValuesRoute'),
            $this->formatAttributeJs('add_attribute_route', 'sAddAttributeRoute'),
            $this->formatAttributeJs('add_attribute_value_route', 'sAddAttributeValueRoute'),
            $this->formatAttributeJs('category_field', 'sCategoryField'),
            $this->formatAttributeJs('price_field', 'sPriceField'),
            $this->formatAttributeJs('allow_generate', 'bAllowGenerate'),
            $this->formatAttributeJs('vat_field_name', 'sVatField'),
            $this->formatAttributeJs('vat_values', 'aoVatValues', ElementInterface::TYPE_OBJECT),
            $this->formatAttributeJs('currency', 'sCurrency'),
            $this->formatAttributeJs('photos', 'aoPhotos', ElementInterface::TYPE_OBJECT),
            $this->formatAttributeJs('availability', 'aoAvailability', ElementInterface::TYPE_OBJECT),
            $this->formatAttributeJs('suffixes', 'aoSuffixes', ElementInterface::TYPE_OBJECT),
            $this->formatAttributeJs('set', 'sSet'),
            $this->formatRepeatableJs(),
            $this->formatRulesJs(),
            $this->formatDependencyJs(),
        ];
    }
}