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

namespace WellCommerce\Bundle\CompanyBundle\Factory;

use WellCommerce\Bundle\CompanyBundle\Entity\Company;
use WellCommerce\Bundle\CompanyBundle\Entity\CompanyInterface;
use WellCommerce\Bundle\DoctrineBundle\Factory\AbstractEntityFactory;

/**
 * Class CompanyFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class CompanyFactory extends AbstractEntityFactory
{
    /**
     * @var CompanyAddressFactory
     */
    private $companyAddressFactory;
    
    /**
     * CompanyFactory constructor.
     *
     * @param CompanyAddressFactory $companyAddressFactory
     */
    public function __construct(CompanyAddressFactory $companyAddressFactory)
    {
        $this->companyAddressFactory = $companyAddressFactory;
    }
    
    public function create() : CompanyInterface
    {
        $company = new Company();
        $company->setName('');
        $company->setShortName('');
        $company->setAddress($this->companyAddressFactory->create());

        return $company;
    }
}
