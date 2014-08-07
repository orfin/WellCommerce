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
use WellCommerce\Bundle\CompanyBundle\Entity\Company;
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
        $query = $this->getDoctrine()->createQuery("SELECT c FROM Company c");
        $companies = $query->getResult();
        print_r($companies);

        $repository = $this->getDoctrine()->getRepository('WellCommerceCompanyBundle:Company');

        $query = $repository->createQueryBuilder('c')->getQuery();

        return $query;
    }
} 