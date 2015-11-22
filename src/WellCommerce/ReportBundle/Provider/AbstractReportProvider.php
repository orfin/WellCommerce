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

namespace WellCommerce\ReportBundle\Provider;

use WellCommerce\AppBundle\DependencyInjection\AbstractContainerAware;
use WellCommerce\AppBundle\Repository\RepositoryInterface;
use WellCommerce\SalesBundle\Entity\OrderInterface;

/**
 * Class AbstractReportProvider
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractReportProvider extends AbstractContainerAware
{
    /**
     * @var RepositoryInterface
     */
    protected $repository;

    /**
     * Constructor
     *
     * @param RepositoryInterface $repository
     */
    public function __construct(RepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Converts the order's gross total to target currency
     *
     * @param OrderInterface $order
     *
     * @return float
     */
    protected function convertAmount(OrderInterface $order)
    {
        $amount       = $order->getOrderTotal()->getGrossAmount();
        $baseCurrency = $order->getCurrency();

        return $this->getCurrencyHelper()->convert($amount, $baseCurrency);
    }
}
