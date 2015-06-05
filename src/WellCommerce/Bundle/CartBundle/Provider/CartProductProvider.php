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

namespace WellCommerce\Bundle\CartBundle\Provider;

use WellCommerce\Bundle\CoreBundle\Provider\AbstractProvider;
use WellCommerce\Bundle\IntlBundle\Converter\CurrencyConverterInterface;

/**
 * Class CartProductProvider
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CartProductProvider extends AbstractProvider implements CartProductProviderInterface
{
    /**
     * @var null|array
     */
    protected $dataset = null;

    /**
     * @var CurrencyConverterInterface
     */
    protected $converter;

    /**
     * @param CurrencyConverterInterface $converter
     */
    public function setCurrencyConverter(CurrencyConverterInterface $converter)
    {
        $this->converter = $converter;
    }

    /**
     * {@inheritdoc}
     */
    public function getProducts()
    {
        return $this->getDataSet();
    }

    /**
     * {@inheritdoc}
     */
    public function getSummary()
    {
        $dataset  = $this->getDataSet();
        $products = $dataset['rows'];
        $weight   = 0;
        $price    = 0;
        $quantity = 0;

        foreach ($products as $product) {
            $weight += $product['weight'];
            $price += $this->converter->convert($product['quantityPrice'], $product['currency']);
            $quantity += $product['quantity'];
        }

        return [
            'weight'   => $weight,
            'price'    => $price,
            'quantity' => $quantity,
        ];
    }

    protected function getDataSet()
    {
        if (null === $this->dataset) {
            $this->dataset = $this->getCollectionBuilder()->getDataSet([
                'order_by' => 'name',
            ]);
        }

        return $this->dataset;
    }
}
