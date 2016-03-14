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

namespace WellCommerce\Bundle\ProductBundle\Helper;

use Doctrine\Common\Collections\Collection;
use WellCommerce\Bundle\AttributeBundle\Entity\AttributeValueInterface;
use WellCommerce\Bundle\CurrencyBundle\Helper\CurrencyHelperInterface;
use WellCommerce\Bundle\ProductBundle\Entity\VariantInterface;

/**
 * Class VariantHelper
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class VariantHelper implements VariantHelperInterface
{
    /**
     * @var CurrencyHelperInterface
     */
    protected $currencyHelper;

    /**
     * Constructor
     *
     * @param CurrencyHelperInterface $currencyHelper
     */
    public function __construct(CurrencyHelperInterface $currencyHelper)
    {
        $this->currencyHelper = $currencyHelper;
    }

    /**
     * {@inheritdoc}
     */
    public function getAttributeGroups(Collection $productAttributeCollection)
    {
        $groups = [];

        $productAttributeCollection->map(function (VariantInterface $variant) use (&$groups) {
            $values = $variant->getAttributeValues();
            $this->extractValues($values, $groups);
        });

        return $groups;
    }

    /**
     * {@inheritdoc}
     */
    public function getAttributes(Collection $productAttributeCollection)
    {
        $attributes = [];

        $productAttributeCollection->map(function (VariantInterface $variant) use (&$attributes) {
            $key              = $this->generateVariantKey($variant);
            $attributes[$key] = $this->getAttributeData($variant);
        });

        return $attributes;
    }

    /**
     * Extracts information from collection and appends it to an array of attributes
     *
     * @param Collection $collection
     * @param array      $attributes
     */
    protected function extractValues(Collection $collection, &$attributes)
    {
        $collection->map(function (AttributeValueInterface $attributeValue) use (&$attributes) {
            $attribute = $attributeValue->getAttribute();

            $attributes[$attribute->getId()]['name']                             = $attribute->translate()->getName();
            $attributes[$attribute->getId()]['values'][$attributeValue->getId()] = $attributeValue->translate()->getName();
        });
    }

    /**
     * Generates an attribute's key on base of its values
     *
     * @param VariantInterface $variant
     *
     * @return string
     */
    protected function generateVariantKey(VariantInterface $variant)
    {
        $values = [];
        $variant->getAttributeValues()->map(function (AttributeValueInterface $attributeValue) use (&$values) {
            $values[$attributeValue->getId()] = $attributeValue->getId();
        });

        ksort($values);

        return implode(',', $values);
    }

    /**
     * Returns the attribute's data
     *
     * @param VariantInterface $variant
     *
     * @return array
     */
    protected function getAttributeData(VariantInterface $variant)
    {
        $sellPrice    = $variant->getSellPrice();
        $baseCurrency = $sellPrice->getCurrency();

        return [
            'id'                 => $variant->getId(),
            'finalPriceGross'    => $this->currencyHelper->convertAndFormat($sellPrice->getFinalGrossAmount(), $baseCurrency),
            'sellPriceGross'     => $this->currencyHelper->convertAndFormat($sellPrice->getGrossAmount(), $baseCurrency),
            'discountPriceGross' => $this->currencyHelper->convertAndFormat($sellPrice->getDiscountedGrossAmount(), $baseCurrency),
            'stock'              => $variant->getStock(),
            'symbol'             => $variant->getSymbol()
        ];
    }
}
