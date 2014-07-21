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

namespace WellCommerce\Core\Form\Elements;

use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use WellCommerce\Tax\Repository\TaxRepositoryInterface;

/**
 * Class RangeEditor
 *
 * @package WellCommerce\Core\Form\Elements
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class RangeEditor extends OptionedField implements ElementInterface
{
    const RANGE_PRECISION = 2;
    const PRICE_PRECISION = 2;

    /**
     * @var TaxRepositoryInterface
     */
    private $repository;

    /**
     * Constructor
     *
     * @param                        $attributes Element options
     * @param TaxRepositoryInterface $repository Tax repository
     */
    public function __construct($attributes, TaxRepositoryInterface $repository)
    {
        $this->repository         = $repository;
        $attributes['vat_values'] = $this->repository->getAllTaxToSelect();
        parent::__construct($attributes);
    }

    /**
     * {@inheritdoc}
     */
    public function configureAttributes(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired([
            'name',
            'label',
        ]);

        $resolver->setOptional([
            'comment',
            'suffix',
            'price_precision',
            'range_precision',
            'range_suffix',
            'prefixes',
            'allow_vat',
            'error',
            'vat_values',
        ]);

        $resolver->setDefaults([
            'range_precision' => self::RANGE_PRECISION,
            'price_precision' => self::PRICE_PRECISION,
            'options'         => [],
            'vat_values'      =>
                function (Options $options) {
                    if (isset($options['allow_vat']) && !$options['allow_vat']) {
                        return [];
                    }

                    return $options['vat_values'];
                },
        ]);

        $resolver->setAllowedTypes([
            'name'            => 'string',
            'label'           => 'string',
            'comment'         => 'string',
            'suffix'          => 'string',
            'price_precision' => 'int',
            'range_precision' => 'int',
            'range_suffix'    => 'string',
            'prefixes'        => 'array',
            'allow_vat'       => 'bool',
            'error'           => 'string',
            'vat_values'      => 'array',
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
            $this->formatAttributeJs('price_precision', 'iPricePrecision'),
            $this->formatAttributeJs('range_precision', 'iRangePrecision'),
            $this->formatAttributeJs('range_suffix', 'sRangeSuffix'),
            $this->formatAttributeJs('prefixes', 'asPrefixes'),
            $this->formatAttributeJs('allow_vat', 'bAllowVat', ElementInterface::TYPE_BOOLEAN),
            $this->formatAttributeJs('error', 'sError'),
            $this->formatAttributeJs('vat_values', 'aoVatValues', ElementInterface::TYPE_OBJECT),
            $this->formatOptionsJs(),
            $this->formatRulesJs(),
            $this->formatDependencyJs(),
            $this->formatDefaultsJs()
        ];
    }
}
