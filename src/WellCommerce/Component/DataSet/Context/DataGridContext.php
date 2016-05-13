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
use WellCommerce\Component\DataSet\Cache\CacheOptions;
use WellCommerce\Component\DataSet\Cache\DataSetCacheManagerInterface;
use WellCommerce\Component\DataSet\Column\ColumnCollection;
use WellCommerce\Component\DataSet\Paginator\DataSetPaginatorInterface;
use WellCommerce\Component\DataSet\Request\DataSetRequestInterface;

/**
 * Class DataGridContext
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class DataGridContext extends AbstractDataSetContext
{
    /**
     * @var DataSetPaginatorInterface
     */
    protected $paginator;

    /**
     * DataGridContext constructor.
     *
     * @param DataSetPaginatorInterface    $paginator
     * @param DataSetCacheManagerInterface $cacheManager
     */
    public function __construct(DataSetPaginatorInterface $paginator, DataSetCacheManagerInterface $cacheManager)
    {
        parent::__construct($cacheManager);
        $this->paginator = $paginator;
    }

    /**
     * {@inheritdoc}
     */
    public function getResult(QueryBuilder $builder, DataSetRequestInterface $request, ColumnCollection $columns, CacheOptions $cache)
    {
        $total    = $this->paginator->getTotalRows($builder, $columns);
        $result   = parent::getResult($builder, $request, $columns, $cache);
        $filtered = ($request->getConditions()->count() !== 0) ? count($result) : $total;

        return [
            'data_id'       => $this->options['data_id'],
            'rows_num'      => $total,
            'starting_from' => $request->getOffset(),
            'total'         => $total,
            'filtered'      => $total,
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
            'cache'   => false
        ]);

        $resolver->setAllowedTypes('data_id', 'numeric');
    }
}
