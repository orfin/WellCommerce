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
namespace WellCommerce\Bundle\ProductBundle\Collection;

use Doctrine\ORM\Tools\Pagination\Paginator;
use Proxies\__CG__\WellCommerce\Bundle\ProductBundle\Entity\ProductTranslation;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use WellCommerce\Bundle\ProductBundle\Collection\Processor\ProductCollectionProcessorInterface;
use WellCommerce\Bundle\ProductBundle\Repository\ProductCollectionAwareRepositoryInterface;

/**
 * Class AbstractProductCollection
 *
 * @package WellCommerce\Bundle\ProductBundle\Collection
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractProductCollection
{
    /**
     * @var ProductCollectionAwareRepositoryInterface
     */
    protected $repository;

    /**
     * @var ProductCollectionProcessorInterface
     */
    protected $processor;

    /**
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

    /**
     * @var string Order column
     */
    protected $orderBy;

    /**
     * @var string Order direction
     */
    protected $orderDir;

    /**
     * @var object
     */
    protected $paginatorQuery;

    /**
     * Constructor
     *
     * @param ProductCollectionAwareRepositoryInterface $repository
     * @param ProductCollectionProcessorInterface       $processor
     * @param EventDispatcherInterface                  $eventDispatcher
     */
    public function __construct(
        ProductCollectionAwareRepositoryInterface $repository,
        ProductCollectionProcessorInterface $processor,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->repository      = $repository;
        $this->processor       = $processor;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function setCurrentPage($page)
    {
        $this->page = $page;
    }

    public function setOrderBy($orderBy)
    {
        $this->orderBy = $orderBy;
    }

    public function setOrderDir($orderDir)
    {
        $this->orderDir = $orderDir;
    }

    public function setCriteria(array $criteria)
    {
        $this->criteria = $criteria;
    }

    /**
     * Returns collection results
     *
     * @param Request $request
     * @param array   $criteria
     *
     * @return array
     */
    public function getResults(Request $request)
    {
        $queryBuilder   = $this->repository->getProductCollectionQueryBuilder();
        $paginatorQuery = clone $queryBuilder;
        $paginator      = new Paginator($paginatorQuery->getQuery());

        $queryBuilder->addOrderBy($this->orderBy, $this->orderDir);

        return $this->processor->process($queryBuilder, $request);
    }
}