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

namespace WellCommerce\Bundle\CurrencyBundle\Formatter;

use WellCommerce\Bundle\CoreBundle\Helper\Request\RequestHelperInterface;
use WellCommerce\Bundle\CurrencyBundle\Exception\CurrencyFormatterException;

/**
 * Class CurrencyFormatter
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class CurrencyFormatter implements CurrencyFormatterInterface
{
    /**
     * @var RequestHelperInterface
     */
    protected $requestHelper;

    /**
     * @var null|string
     */
    protected $forcedLocale;

    /**
     * CurrencyFormatter constructor.
     *
     * @param RequestHelperInterface $requestHelper
     * @param null                   $forcedLocale
     */
    public function __construct(RequestHelperInterface $requestHelper, $forcedLocale = null)
    {
        $this->requestHelper = $requestHelper;
        $this->forcedLocale  = $forcedLocale;
    }

    /**
     * {@inheritdoc}
     */
    public function format($amount, $currency = null, $locale = null)
    {
        if (null === $currency) {
            $currency = $this->requestHelper->getCurrentCurrency();
        }

        $locale    = $this->getLocale($locale);
        $formatter = new \NumberFormatter($locale, \NumberFormatter::CURRENCY);
        if (false === $result = $formatter->formatCurrency($amount, $currency)) {
            throw new CurrencyFormatterException($amount, $currency, $locale);
        }

        return $result;
    }

    private function getLocale(string $locale = null) : string
    {
        if (null === $locale) {
            if (null === $this->forcedLocale) {
                return $this->requestHelper->getCurrentLocale();
            } else {
                return $this->forcedLocale;
            }
        }

        return $locale;
    }
}
