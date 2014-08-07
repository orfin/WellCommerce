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

namespace WellCommerce\Bundle\CompanyBundle\DataGrid;

use WellCommerce\Bundle\CoreBundle\DataGrid\QueryBuilder\AbstractQueryBuilder;
use WellCommerce\Bundle\CoreBundle\DataGrid\QueryBuilder\QueryBuilderInterface;

/**
 * Class CompanyDataGridQuery
 *
 * @package WellCommerce\Company\DataGrid
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CompanyDataGridQuery extends AbstractQueryBuilder implements QueryBuilderInterface
{
    /**
     * {@inheritdoc}
     */
    public function getQuery()
    {
        $qb = $this->getManager()->table('company');
        $qb->groupBy('company.id');

        return $qb;
    }
} 