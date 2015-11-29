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

namespace WellCommerce\Bundle\AppBundle\Service\Currency\Importer;

use WellCommerce\Bundle\AppBundle\Entity\Currency;

/**
 * Class EcbRatesImporter
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class EcbRatesImporter extends AbstractExchangeRatesImporter implements ExchangeRatesImporterInterface
{
    protected $url          = 'http://www.ecb.int/stats/eurofxref/eurofxref-daily.xml';
    protected $baseCurrency = 'EUR';
    protected $table        = [];

    /**
     * {@inheritdoc}
     */
    public function importExchangeRates()
    {
        $this->downloadExchangeRatesTable();

        foreach ($this->getCurrencies() as $currency) {
            $this->updateCurrencyRates($currency);
        }
    }

    /**
     * Downloads exchange rates table from ECB
     */
    protected function downloadExchangeRatesTable()
    {

        try {
            $this->table[$this->baseCurrency] = 1;

            $xml = simplexml_load_file($this->url, 'SimpleXMLElement', LIBXML_NOWARNING);

            if ($xml instanceof \SimpleXMLElement) {
                $data = $xml->xpath('//gesmes:Envelope/*[3]/*');
                foreach ($data[0]->children() as $child) {
                    $currency               = (string)$child->attributes()->currency;
                    $exchangeRate           = (string)$child->attributes()->rate;
                    $this->table[$currency] = $exchangeRate;
                }
            }
        } catch (\Exception $e) {
            throw new \RuntimeException('Cannot download rates from ECB.');
        }

    }

    /**
     * Updates managed currency with exchange rates
     *
     * @param Currency $currency
     */
    protected function updateCurrencyRates(Currency $currency)
    {
        $baseExchangeRate = $this->table[$currency->getCode()];

        foreach ($this->table as $currencySymbol => $exchangeRate) {
            $rate = $this->calculateExchangeRate($baseExchangeRate, $currencySymbol);
            $this->addUpdateExchangeRate($currency->getCode(), $currencySymbol, $rate);
        }

        $this->helper->getEntityManager()->flush();
    }

    /**
     * Calculates exchange rate for base currency
     *
     * @param float  $baseExchangeRate
     * @param string $currencySymbol
     *
     * @return float
     */
    protected function calculateExchangeRate($baseExchangeRate, $currencySymbol)
    {
        return (1 / $baseExchangeRate) * $this->table[$currencySymbol];
    }
}
