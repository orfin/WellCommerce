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

/**
 * Interface ProductCollectionProcessorInterface
 *
 * @package WellCommerce\Bundle\ProductBundle\Collection\Processor
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ProductCollectionProcessorInterface
{
    /**
     * Processes product collection
     *
     * @param QueryBuilder $queryBuilder
     * @param Request      $request
     *
     * @return mixed
     */
    public function process(QueryBuilder $queryBuilder, Request $request);
} 