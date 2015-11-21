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

namespace WellCommerce\CoreBundle\Component\DataSet\Context;

use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\OptionsResolver\OptionsResolver;
use WellCommerce\CoreBundle\Component\DataSet\Column\ColumnCollection;
use WellCommerce\CoreBundle\Component\DataSet\Paginator\DataSetPaginatorInterface;
use WellCommerce\CoreBundle\Component\DataSet\Request\DataSetRequestInterface;

/**
 * Class DataGridContext
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class DataGridContext extends AbstractDataSetContext implements DataSetContextInterface
{
    /**
     * @var DataSetPaginatorInterface
     */
    protected $paginator;

    /**
     * Constructor
     *
     * @param DataSetPaginatorInterface $paginator
     */
    public function __construct(DataSetPaginatorInterface $paginator)
    {
        $this->paginator = $paginator;
    }

    /**
     * {@inheritdoc}
     */
    public function getResult(QueryBuilder $queryBuilder, DataSetRequestInterface $request, ColumnCollection $columns)
    {
        $total    = $this->paginator->getTotalRows($queryBuilder, $columns);
        $result   = parent::getResult($queryBuilder, $request, $columns);
        $filtered = ($request->getConditions()->count() !== 0) ? count($result) : $total;

        return [
            'data_id'       => $this->options['data_id'],
            'rows_num'      => $total,
            'starting_from' => $request->getOffset(),
            'total'         => $total,
            'filtered'      => $filtered,
            'rows'          => $result
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setRequired([
            'data_id',
        ]);

        $resolver->setDefaults([
            'data_id' => 0,
        ]);

        $resolver->setAllowedTypes([
            'data_id' => ['numeric'],
        ]);
    }
}
