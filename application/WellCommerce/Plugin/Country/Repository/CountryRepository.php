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
namespace WellCommerce\Plugin\Country\Repository;

use WellCommerce\Core\Repository;
use Symfony\Component\Intl\Intl;

/**
 * Class CountryRepository
 *
 * @package WellCommerce\Plugin\Country\Repository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CountryRepository extends Repository
{

    /**
     * Returns all country names for given locale
     *
     * @param string $locale
     *
     * @return \string[]
     */
    public function all($locale = 'en')
    {
        return Intl::getRegionBundle()->getCountryNames($locale);
    }
}