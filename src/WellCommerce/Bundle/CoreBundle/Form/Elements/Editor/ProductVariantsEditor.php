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
use WellCommerce\Bundle\CoreBundle\Form\Elements\ElementInterface;

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

        $resolver->setDefined([
            'photos',
            'availability',
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
            'availability_field' => 'WellCommerce\Bundle\CoreBundle\Form\Elements\ElementInterface',
            'vat_field'          => 'WellCommerce\Bundle\CoreBundle\Form\Elements\ElementInterface',
            'vat_values'         => 'array',
            'photos'             => 'array',
            'availability'       => 'array',
            'price_field'        => 'WellCommerce\Bundle\CoreBundle\Form\Elements\ElementInterface',
            'category_field'     => 'WellCommerce\Bundle\CoreBundle\Form\Elements\ElementInterface',
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
    public function prepareAttributes()
    {
        return parent::prepareAttributes() + [
            'sGetGroupsRoute'           => $this->getOption('get_groups_route'),
            'sGetAttributesRoute'       => $this->getOption('get_attributes_route'),
            'sGetAttributesValuesRoute' => $this->getOption('get_attributes_values_route'),
            'sAddAttributeRoute'        => $this->getOption('add_attribute_route'),
            'sAddAttributeValueRoute'   => $this->getOption('add_attribute_value_route'),
            'sCategoryField'            => $this->getOption('category_field'),
            'sPriceField'               => $this->getOption('price_field'),
            'bAllowGenerate'            => $this->getOption('allow_generate'),
            'sVatField'                 => $this->getOption('vat_field'),
            'aoVatValues'               => $this->getOption('vat_values'),
            'aoPhotos'                  => $this->getOption('photos'),
            'aoAvailability'            => $this->getOption('availability'),
            'aoSuffixes'                => $this->getOption('suffixes'),
            'sSet'                      => $this->getOption('set'),
        ];

        print_r($attributes);
        die();

    }
}