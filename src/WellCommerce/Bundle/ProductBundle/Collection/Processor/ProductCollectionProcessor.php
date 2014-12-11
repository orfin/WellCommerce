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

namespace WellCommerce\Bundle\ProductBundle\Collection\Processor;

use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PropertyAccess\PropertyAccess;
use WellCommerce\Bundle\ProductBundle\Collection\Item\Item;
use WellCommerce\Bundle\ProductBundle\Collection\Item\ItemCollection;

/**
 * Class ProductCollectionProcessor
 *
 * @package WellCommerce\Bundle\ProductBundle\Collection\Processor
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductCollectionProcessor implements ProductCollectionProcessorInterface
{
    /**
     * @var QueryBuilder
     */
    protected $queryBuilder;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var \Symfony\Component\PropertyAccess\PropertyAccessor
     */
    protected $propertyAccessor;

    /**
     * @var ItemCollection
     */
    protected $collection;

    /**
     * {@inheritdoc}
     */
    public function process(QueryBuilder $queryBuilder, Request $request)
    {
        $this->queryBuilder     = $queryBuilder;
        $this->request          = $request;
        $this->propertyAccessor = PropertyAccess::createPropertyAccessor();
        $this->collection       = new ItemCollection();

        $this->processCollection();

        return $this->collection;
    }

    private function processCollection()
    {
        $query  = $this->queryBuilder->getQuery();
        $result = $query->getArrayResult();

        foreach ($result as $row) {
            $this->collection->add(new Item($row, $this->request->getLocale()));
        }
    }

} 