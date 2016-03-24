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

namespace WellCommerce\Bundle\LocaleBundle\Repository;

use WellCommerce\Bundle\DoctrineBundle\Repository\RepositoryInterface;

/**
 * Interface LocaleRepositoryInterface
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
interface LocaleRepositoryInterface extends RepositoryInterface
{
    /**
     * Returns an array of locales fetched from intl component
     *
     * @return array
     */
    public function getLocaleNames() : array;

    /**
     * Returns defined locales as an array
     *
     * @return array
     */
    public function getAvailableLocales() : array;
}
