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
use Symfony\Component\PropertyAccess\PropertyAccess;
use WellCommerce\Component\DataSet\Cache\CacheOptions;
use WellCommerce\Component\DataSet\Cache\DataSetCacheManagerInterface;
use WellCommerce\Component\DataSet\Column\ColumnCollection;
use WellCommerce\Component\DataSet\Request\DataSetRequestInterface;
use WellCommerce\Component\DataSet\Transformer\ColumnTransformerCollection;

/**
 * Class AbstractDataSetContext
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractDataSetContext implements DataSetContextInterface
{
    /**
     * @var array
     */
    protected $options;
    
    /**
     * @var ColumnTransformerCollection
     */
    protected $columnTransformers;
    
    /**
     * @var DataSetCacheManagerInterface
     */
    protected $cacheManager;
    
    /**
     * @var \Symfony\Component\PropertyAccess\PropertyAccessor
     */
    protected $propertyAccessor;
    
    /**
     * AbstractDataSetContext constructor.
     *
     * @param DataSetCacheManagerInterface $cacheManager
     */
    public function __construct(DataSetCacheManagerInterface $cacheManager)
    {
        $this->cacheManager = $cacheManager;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configure(array $options = [])
    {
        $optionsResolver = new OptionsResolver();
        $this->configureOptions($optionsResolver);
        $this->options          = $optionsResolver->resolve($options);
        $this->propertyAccessor = $this->getPropertyAccessor();
    }
    
    /**
     * {@inheritdoc}
     */
    public function getResult(QueryBuilder $builder, DataSetRequestInterface $request, ColumnCollection $columns, CacheOptions $cache)
    {
        $query = $builder->getQuery();
        $query->useQueryCache($this->options['cache']);
        $query->useResultCache(false);
        
        if ($cache->isEnabled()) {
            $result = $this->cacheManager->getCachedDataSetResult($query, $cache);
        } else {
            $result = $query->getArrayResult();
        }
        
        return $this->transformResult($result);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired([
            'cache',
        ]);
        
        $resolver->setDefaults([
            'cache' => true,
        ]);
        
        $resolver->setAllowedTypes('cache', 'bool');
    }
    
    /**
     * @return \Symfony\Component\PropertyAccess\PropertyAccessor
     */
    protected function getPropertyAccessor()
    {
        return PropertyAccess::createPropertyAccessor();
    }
    
    public function setTransformers(ColumnTransformerCollection $transformers)
    {
        $this->columnTransformers = $transformers;
    }
    
    /**
     * Transforms the results using additional data transformers
     *
     * @param array $result
     *
     * @return array
     */
    protected function transformResult(array $result)
    {
        if ($this->columnTransformers->count()) {
            foreach ($result as $index => $row) {
                $result[$index] = $this->transformRow($row);
            }
        }
        
        return $result;
    }
    
    /**
     * Processes the row data
     *
     * @param array $row
     *
     * @return array
     */
    protected function transformRow($row)
    {
        foreach ($row as $field => $value) {
            if ($this->columnTransformers->has($field)) {
                $row[$field] = $this->columnTransformers->get($field)->transformValue($value);
            }
        }
        
        return $row;
    }
}
