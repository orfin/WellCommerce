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
namespace WellCommerce\Bundle\ProductStatusBundle\Twig\Extension;

use WellCommerce\Bundle\DoctrineBundle\Repository\RepositoryInterface;
use WellCommerce\Bundle\ProductStatusBundle\Entity\ProductStatusInterface;
use WellCommerce\Component\DataSet\DataSetInterface;

/**
 * Class ProductStatusExtension
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductStatusExtension extends \Twig_Extension
{
    /**
     * @var DataSetInterface
     */
    protected $dataset;

    /**
     * @var RepositoryInterface
     */
    protected $repository;

    /**
     * ProductStatusExtension constructor.
     *
     * @param DataSetInterface    $dataset
     * @param RepositoryInterface $repository
     */
    public function __construct(DataSetInterface $dataset, RepositoryInterface $repository)
    {
        $this->dataset    = $dataset;
        $this->repository = $repository;
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('productStatuses', [$this, 'getProductStatuses'], ['is_safe' => ['html']]),
            new \Twig_SimpleFunction('productStatus', [$this, 'getProductStatusBySymbol'], ['is_safe' => ['html']]),
        ];
    }

    public function getProductStatuses(int $limit = 5, string $orderBy = 'name', string $orderDir = 'asc') : array
    {
        return $this->dataset->getResult('array', [
            'limit'     => $limit,
            'order_by'  => $orderBy,
            'order_dir' => $orderDir,
        ], [
            'pagination' => false
        ]);
    }

    public function getProductStatusBySymbol(string $symbol) : ProductStatusInterface
    {
        return $this->repository->findOneBy(['symbol' => $symbol]);
    }

    public function getName()
    {
        return 'product_status';
    }
}
