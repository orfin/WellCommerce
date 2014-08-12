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

namespace WellCommerce\Bundle\LocaleBundle\LocaleProvider;

use WellCommerce\Bundle\LocaleBundle\Repository\LocaleRepositoryInterface;

/**
 * Interface LocaleProviderInterface
 *
 * @package WellCommerce\Bundle\LocaleBundle\LocaleProvider
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface LocaleProviderInterface
{
    /**
     * Returns available system locales
     *
     * @return mixed
     */
    public function getAvailableLocales();

    /**
     * Checks whether locale is registered and available
     *
     * @param $locale
     *
     * @return mixed
     */
    public function isAvailableLocale($locale);
} 