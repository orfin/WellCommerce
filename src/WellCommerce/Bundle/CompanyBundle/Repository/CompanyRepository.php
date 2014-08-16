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

namespace WellCommerce\Bundle\CompanyBundle\Repository;

use WellCommerce\Bundle\CoreBundle\Repository\AbstractEntityRepository;

/**
 * Class CompanyRepository
 *
 * @package WellCommerce\Bundle\CompanyBundle\Repository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CompanyRepository extends AbstractEntityRepository implements CompanyRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getDataGridQueryBuilder()
    {
        return parent::getQueryBuilder()->groupBy('company.id');
    }

    public function getCollectionToSelect($labelField = 'name')
    {
        $companies = [];
        $accessor  = $this->getPropertyAccessor();
        $result    = $this->createQueryBuilder('company')->getQuery()->getResult();

        foreach ($result as $company) {
            $id             = $accessor->getValue($company, 'id');
            $label          = $accessor->getValue($company, $labelField);
            $companies[$id] = $label;
        }

        return $companies;
    }
}
