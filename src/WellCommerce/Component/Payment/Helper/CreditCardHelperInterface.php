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

namespace WellCommerce\Component\Payment\Helper;

/**
 * Class CreditCardHelperInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface CreditCardHelperInterface
{
    const CREDIT_CARD_TYPE_AMEX          = 'amex';
    const CREDIT_CARD_TYPE_DISCOVER      = 'discover';
    const CREDIT_CARD_TYPE_MASTERCARD    = 'mastercard';
    const CREDIT_CARD_TYPE_VISA          = 'visa';
    const CREDIT_CARD_PATTERN_AMEX       = '/^3[47][0-9]{13}$/';
    const CREDIT_CARD_PATTERN_DISCOVER   = '/^6(?:011|5[0-9][0-9])[0-9]{12}$/';
    const CREDIT_CARD_PATTERN_MASTERCARD = '/^5[1-5][0-9]{14}$/';
    const CREDIT_CARD_PATTERN_VISA       = '/^4[0-9]{12}(?:[0-9]{3})?$/';

    public function getCreditCardType(string $number) : string;

    public function isType(string $number, string $type) : bool;

    public function clearNumber(string $number) : string;

    public function getCreditCardPatterns() : array;
}
