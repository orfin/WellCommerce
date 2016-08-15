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

use Doctrine\ORM\QueryBuilder;
use Symfony\Component\OptionsResolver\OptionsResolver;
use WellCommerce\Component\DataSet\Cache\CacheOptions;
use WellCommerce\Component\DataSet\Cache\DataSetCacheManagerInterface;
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
     * ArrayContext constructor.
     *
     * @param DataSetPaginationInterface   $pagination
     * @param DataSetCacheManagerInterface $cacheManager
     */
    public function __construct(DataSetPaginationInterface $pagination, DataSetCacheManagerInterface $cacheManager)
    {
        parent::__construct($cacheManager);
        $this->pagination   = $pagination;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getResult(QueryBuilder $builder, DataSetRequestInterface $request, ColumnCollection $columns, CacheOptions $cache)
    {
        $pagination = ($this->options['pagination']) ? $this->pagination->getPagination($builder, $request, $columns) : null;
        $limit      = $request->getLimit();
        $offset     = $request->getOffset();
        $result     = parent::getResult($builder, $request, $columns, $cache);

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
