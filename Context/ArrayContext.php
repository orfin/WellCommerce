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

namespace WellCommerce\Component\DataSet\Context;

use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\OptionsResolver\OptionsResolver;
use WellCommerce\Component\DataSet\Column\ColumnCollection;
use WellCommerce\Component\DataSet\Pagination\DataSetPaginationInterface;
use WellCommerce\Component\DataSet\Request\DataSetRequestInterface;

/**
 * Class ArrayContext
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class ArrayContext extends AbstractDataSetContext
{
    /**
     * @var DataSetPaginationInterface
     */
    protected $pagination;

    /**
     * Constructor
     *
     * @param DataSetPaginationInterface $pagination
     */
    public function __construct(DataSetPaginationInterface $pagination)
    {
        $this->pagination = $pagination;
    }

    /**
     * {@inheritdoc}
     */
    public function getResult(QueryBuilder $queryBuilder, DataSetRequestInterface $request, ColumnCollection $columns)
    {
        if ($this->options['pagination']) {
            return $this->getPaginatedResult($queryBuilder, $request, $columns);
        }

        $result = parent::getResult($queryBuilder, $request, $columns);

        return [
            'rows' => $result,
        ];
    }

    protected function getPaginatedResult(QueryBuilder $queryBuilder, DataSetRequestInterface $request, ColumnCollection $columns)
    {
        $pagination = $this->pagination->getPagination($queryBuilder, $request, $columns);
        $result     = parent::getResult($queryBuilder, $request, $columns);
        $limit      = $request->getLimit();
        $offset     = $request->getOffset();

        return [
            'offset'     => $offset,
            'limit'      => $limit,
            'pagination' => $pagination,
            'rows'       => $result,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setRequired([
            'pagination',
        ]);

        $resolver->setDefaults([
            'pagination' => true,
        ]);

        $resolver->setAllowedTypes('pagination', 'bool');
    }
}
