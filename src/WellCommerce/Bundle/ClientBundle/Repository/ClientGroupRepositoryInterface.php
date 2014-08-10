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

namespace WellCommerce\Bundle\ClientBundle\Repository;

use WellCommerce\Bundle\CompanyBundle\Entity\Company;

/**
 * Interface ClientGroupRepositoryInterface
 *
 * @package WellCommerce\Bundle\ClientBundle\Repository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ClientGroupRepositoryInterface
{
    /**
     * Returns translations for given entity
     *
     * @param Company $company
     *
     * @return mixed
     */
    public function findTranslations($company);
} 