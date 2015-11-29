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

namespace WellCommerce\Bundle\AppBundle\Service\Currency\Formatter;

use WellCommerce\Bundle\AppBundle\Exception\CurrencyFormatterException;
use WellCommerce\Bundle\CoreBundle\Helper\Request\RequestHelperInterface;

/**
 * Class CurrencyFormatter
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CurrencyFormatter implements CurrencyFormatterInterface
{
    /**
     * @var RequestHelperInterface
     */
    protected $requestHelper;

    /**
     * Constructor
     *
     * @param RequestHelperInterface $requestHelper
     */
    public function __construct(RequestHelperInterface $requestHelper)
    {
        $this->requestHelper = $requestHelper;
    }

    /**
     * {@inheritdoc}
     */
    public function format($amount, $currency = null, $locale = null)
    {
        if (null === $currency) {
            $currency = $this->requestHelper->getCurrentCurrency();
        }

        if (null === $locale) {
            $locale = $this->requestHelper->getCurrentLocale();
        }

        $formatter = new \NumberFormatter($locale, \NumberFormatter::CURRENCY);
        if (false === $result = $formatter->formatCurrency($amount, $currency)) {
            throw new CurrencyFormatterException($amount, $currency, $locale);
        }

        return $result;
    }
}
