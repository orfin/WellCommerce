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
     * Constructor
     *
     * @param DataSetInterface $dataset
     */
    public function __construct(DataSetInterface $dataset)
    {
        $this->dataset = $dataset;
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('productStatuses', [$this, 'getProductStatuses'], ['is_safe' => ['html']]),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'product_status';
    }

    /**
     * Returns product statuses
     *
     * @param int    $limit
     * @param string $orderBy
     * @param string $orderDir
     *
     * @return array
     */
    public function getProductStatuses($limit = 5, $orderBy = 'name', $orderDir = 'asc')
    {
        return $this->dataset->getResult('array', [
            'limit'     => $limit,
            'order_by'  => $orderBy,
            'order_dir' => $orderDir,
        ], [
            'pagination' => false
        ]);
    }
}
