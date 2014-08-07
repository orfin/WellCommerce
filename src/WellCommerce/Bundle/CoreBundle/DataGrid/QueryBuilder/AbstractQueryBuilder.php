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

namespace WellCommerce\Bundle\CoreBundle\DataGrid\QueryBuilder;

use Doctrine\ORM\EntityRepository;

/**
 * Class AbstractQueryBuilder
 *
 * @package WellCommerce\Bundle\CoreBundle\DataGrid\QueryBuilder
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractQueryBuilder
{
    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    private $repository;

    /**
     * Constructor
     *
     * @param EntityRepository $repository
     */
    public function __construct(EntityRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Returns entity repository
     *
     * @return EntityRepository
     */
    public function getRepository()
    {
        return $this->repository;
    }

    /**
     * {@inheritdoc}
     */
    public function getOperator($operator)
    {
        switch ($operator) {
            case 'NE':
                return '!=';
                break;
            case 'LE':
                return '<=';
                break;
            case 'GE':
                return '>=';
                break;
            case 'LIKE':
                return 'LIKE';
                break;
            case 'IN':
                return '=';
                break;
            default:
                return '=';
        }
    }
} 