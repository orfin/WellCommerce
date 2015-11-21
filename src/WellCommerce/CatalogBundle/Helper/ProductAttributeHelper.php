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

namespace WellCommerce\CatalogBundle\Helper;

use Doctrine\Common\Collections\Collection;
use WellCommerce\CatalogBundle\Entity\AttributeValueInterface;
use WellCommerce\CatalogBundle\Entity\ProductAttributeInterface;
use WellCommerce\CommonBundle\Helper\CurrencyHelperInterface;

/**
 * Class ProductAttributeHelper
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductAttributeHelper implements ProductAttributeHelperInterface
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

        $productAttributeCollection->map(function (ProductAttributeInterface $productAttribute) use (&$groups) {
            $values = $productAttribute->getAttributeValues();
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

        $productAttributeCollection->map(function (ProductAttributeInterface $productAttribute) use (&$attributes) {
            $key              = $this->generateProductAttributeKey($productAttribute);
            $attributes[$key] = $this->getAttributeData($productAttribute);
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
     * @param ProductAttributeInterface $productAttribute
     *
     * @return string
     */
    protected function generateProductAttributeKey(ProductAttributeInterface $productAttribute)
    {
        $values = [];
        $productAttribute->getAttributeValues()->map(function (AttributeValueInterface $attributeValue) use (&$values) {
            $values[$attributeValue->getId()] = $attributeValue->getId();
        });

        ksort($values);

        return implode(',', $values);
    }

    /**
     * Returns the attribute's data
     *
     * @param ProductAttributeInterface $productAttribute
     *
     * @return array
     */
    protected function getAttributeData(ProductAttributeInterface $productAttribute)
    {
        $sellPrice    = $productAttribute->getSellPrice();
        $baseCurrency = $sellPrice->getCurrency();

        return [
            'id'                 => $productAttribute->getId(),
            'finalPriceGross'    => $this->currencyHelper->convertAndFormat($sellPrice->getFinalGrossAmount(), $baseCurrency),
            'sellPriceGross'     => $this->currencyHelper->convertAndFormat($sellPrice->getGrossAmount(), $baseCurrency),
            'discountPriceGross' => $this->currencyHelper->convertAndFormat($sellPrice->getDiscountedGrossAmount(), $baseCurrency),
            'stock'              => $productAttribute->getStock(),
            'symbol'             => $productAttribute->getSymbol()
        ];
    }
}
