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

namespace WellCommerce\Plugin\Currency\Converter;

use WellCommerce\Plugin\Currency\Repository\CurrencyRepositoryInterface;

/**
 * Class CurrencyConverter
 *
 * @package WellCommerce\Plugin\Currency\Converter
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CurrencyConverter implements CurrencyConverterInterface
{
    private $repository;

    public function __construct(CurrencyRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * {@inheritdoc}
     */
    public function exchange($value, $currency)
    {
        return $value * $currency;
    }
} 