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

namespace WellCommerce\Bundle\LocaleBundle\Manager\Admin;

use WellCommerce\Bundle\CoreBundle\Manager\Admin\AbstractAdminManager;
use WellCommerce\Bundle\CurrencyBundle\Entity\CurrencyInterface;
use WellCommerce\Bundle\LocaleBundle\Copier\LocaleCopierInterface;
use WellCommerce\Bundle\LocaleBundle\Entity\LocaleInterface;

/**
 * Class LocaleManager
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LocaleManager extends AbstractAdminManager
{
    public function createLocale(string $localeCode, string $targetLocaleCurrency) : LocaleInterface
    {
        $currency = $this->getTargetCurrency($targetLocaleCurrency);
        $locale   = $this->initResource();
        $locale->setCode($localeCode);
        $locale->setEnabled(true);
        $locale->setCurrency($currency);
        $this->createResource($locale);

        return $locale;
    }

    public function copyLocaleData(string $sourceLocaleCode, string $targetLocaleCode)
    {
        $sourceLocale = $this->findLocale($sourceLocaleCode);
        $targetLocale = $this->findLocale($targetLocaleCode);

        $this->getLocaleCopier()->copyLocaleData($sourceLocale, $targetLocale);
    }

    protected function getLocaleCopier() : LocaleCopierInterface
    {
        return $this->get('locale.copier');
    }

    protected function findLocale(string $code) : LocaleInterface
    {
        return $this->repository->findOneBy(['code' => $code]);
    }

    protected function getTargetCurrency($targetCurrency) : CurrencyInterface
    {
        return $this->get('currency.repository')->findOneBy(['code' => $targetCurrency]);
    }
}
