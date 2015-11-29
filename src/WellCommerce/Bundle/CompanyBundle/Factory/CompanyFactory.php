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

namespace WellCommerce\Bundle\AppBundle\Factory;

use WellCommerce\Bundle\AppBundle\Entity\Company;
use WellCommerce\Bundle\AppBundle\Entity\CompanyAddress;
use WellCommerce\Bundle\CoreBundle\Factory\AbstractFactory;

/**
 * Class CompanyFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CompanyFactory extends AbstractFactory
{
    /**
     * @return \WellCommerce\Bundle\AppBundle\Entity\CompanyInterface
     */
    public function create()
    {
        $company = new Company();
        $company->setName('');
        $company->setShortName('');
        $company->setAddress(new CompanyAddress());

        return $company;
    }
}
