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

namespace WellCommerce\Bundle\IntlBundle\Repository;

use WellCommerce\Bundle\CoreBundle\Doctrine\ORM\DataSetAwareRepositoryInterface;
use WellCommerce\Bundle\CoreBundle\Repository\RepositoryInterface;

/**
 * Interface LocaleRepositoryInterface
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
interface LocaleRepositoryInterface extends DataSetAwareRepositoryInterface, RepositoryInterface
{
    /**
     * Returns an array of locales fetched from intl component
     *
     * @return mixed
     */
    public function getLocaleNames();

    /**
     * Returns defined locales as an array
     *
     * @return mixed
     */
    public function getAvailableLocales();
} 