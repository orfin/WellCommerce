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

namespace WellCommerce\Contact\DataGrid;

use WellCommerce\Core\DataGrid\QueryBuilder\AbstractQueryBuilder;
use WellCommerce\Core\DataGrid\QueryBuilder\QueryBuilderInterface;

/**
 * Class ContactDataGridQuery
 *
 * @package WellCommerce\Contact\DataGrid
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ContactDataGridQuery extends AbstractQueryBuilder implements QueryBuilderInterface
{
    /**
     * {@inheritdoc}
     */
    public function getQuery()
    {
        $qb = $this->getManager()->table('contact');
        $qb->join('contact_translation', 'contact_translation.contact_id', '=', 'contact.id');
        $qb->groupBy('contact.id');

        return $qb;
    }
} 