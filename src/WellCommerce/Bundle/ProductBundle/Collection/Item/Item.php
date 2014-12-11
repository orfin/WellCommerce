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

namespace WellCommerce\Bundle\ProductBundle\Collection\Item;

use Money\Currency;
use Money\Money;
use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * Class Item
 *
 * @package WellCommerce\Bundle\ProductBundle\Collection\Item
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Item implements ItemInterface
{
    public function __construct($data, $locale)
    {
        $accessor          = PropertyAccess::createPropertyAccessor();
        $this->id          = $accessor->getValue($data, '[id]');
        $this->sellPrice   = $this->processPrice($data['sellPrice'], $data['sellCurrency']['code']);
        $this->translation = $accessor->getValue($data, sprintf('[translations][%s]', $locale));
        $this->photo       = $accessor->getValue($data, '[productPhotos][0][photo]');
    }

    private function processPrice($price, $currency)
    {
        return new Money((int)$price * 100, new Currency($currency));
    }
}