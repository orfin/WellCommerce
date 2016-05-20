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
namespace WellCommerce\Bundle\ProducerBundle\Twig\Extension;

use WellCommerce\Component\DataSet\DataSetInterface;

/**
 * Class ProducerExtension
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class ProducerExtension extends \Twig_Extension
{
    /**
     * @var DataSetInterface
     */
    private $dataset;

    /**
     * ProducerExtension constructor.
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
            new \Twig_SimpleFunction('producers', [$this, 'getProducers'], ['is_safe' => ['html']]),
        ];
    }

    public function getName()
    {
        return 'producers';
    }

    public function getProducers(int $limit = 10, string $orderBy = 'name', string $orderDir = 'asc') : array
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
