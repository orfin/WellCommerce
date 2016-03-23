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

use WellCommerce\Bundle\CurrencyBundle\Helper\CurrencyHelperInterface;
use WellCommerce\Bundle\ProductBundle\Entity\ProductInterface;
use WellCommerce\Bundle\ProductBundle\Entity\VariantInterface;
use WellCommerce\Bundle\ProductBundle\Entity\VariantOptionInterface;

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
     * VariantHelper constructor.
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
    public function getVariants(ProductInterface $product) : array
    {
        $variants = [];

        $product->getVariants()->map(function (VariantInterface $variant) use (&$variants) {
            $this->extractVariantData($variant, $variants);
        });

        return $variants;
    }

    /**
     * {@inheritdoc}
     */
    public function getAttributes(ProductInterface $product) : array
    {
        $attributes = [];

        $product->getVariants()->map(function (VariantInterface $variant) use (&$attributes) {
            $this->extractAttributesData($variant, $attributes);
        });

        return $attributes;
    }

    protected function extractAttributesData(VariantInterface $variant, &$attributes)
    {
        $variant->getOptions()->map(function (VariantOptionInterface $variantOption) use (&$attributes) {
            $attribute                                                           = $variantOption->getAttribute();
            $attributeValue                                                      = $variantOption->getAttributeValue();
            $attributes[$attribute->getId()]['name']                             = $attribute->translate()->getName();
            $attributes[$attribute->getId()]['values'][$attributeValue->getId()] = $attributeValue->translate()->getName();
        });
    }

    protected function extractVariantData(VariantInterface $variant, array &$variants)
    {
        $sellPrice    = $variant->getSellPrice();
        $baseCurrency = $sellPrice->getCurrency();
        $key          = $this->getVariantOptionsKey($variant);

        $variants[$key] = [
            'id'                 => $variant->getId(),
            'finalPriceGross'    => $this->currencyHelper->convertAndFormat($sellPrice->getFinalGrossAmount(), $baseCurrency),
            'sellPriceGross'     => $this->currencyHelper->convertAndFormat($sellPrice->getGrossAmount(), $baseCurrency),
            'discountPriceGross' => $this->currencyHelper->convertAndFormat($sellPrice->getDiscountedGrossAmount(), $baseCurrency),
            'stock'              => $variant->getStock(),
            'symbol'             => $variant->getSymbol(),
        ];
    }

    protected function getVariantOptionsKey(VariantInterface $variant) : string
    {
        $options = [];

        $variant->getOptions()->map(function (VariantOptionInterface $variantOption) use (&$options) {
            $attribute      = $variantOption->getAttribute();
            $attributeValue = $variantOption->getAttributeValue();
            $key            = sprintf('%s:%s', $attribute->getId(), $attributeValue->getId());
            $options[$key]  = $key;
        });

        ksort($options);

        return implode(',', $options);
    }

    public function getVariantOptions(VariantInterface $variant) : array
    {
        $options = [];

        $variant->getOptions()->map(function (VariantOptionInterface $variantOption) use (&$options) {
            $attribute                                   = $variantOption->getAttribute();
            $attributeValue                              = $variantOption->getAttributeValue();
            $options[$attribute->translate()->getName()] = $attributeValue->translate()->getName();
        });

        return $options;
    }
}
