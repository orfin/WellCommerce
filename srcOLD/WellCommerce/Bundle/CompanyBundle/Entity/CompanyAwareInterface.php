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

namespace WellCommerce\Bundle\CompanyBundle\Entity;

/**
 * Interface CompanyAwareInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface CompanyAwareInterface
{
    /**
     * @param CompanyInterface $company
     */
    public function setCompany(CompanyInterface $company);

    /**
     * @return CompanyInterface
     */
    public function getCompany();
}
