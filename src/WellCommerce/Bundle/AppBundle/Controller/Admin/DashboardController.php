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

namespace WellCommerce\Bundle\AppBundle\Controller\Admin;

use Carbon\Carbon;
use DateInterval;
use WellCommerce\Bundle\AppBundle\Controller\AbstractController;
use WellCommerce\Bundle\AppBundle\Calculator\SalesSummaryCalculator;
use WellCommerce\Bundle\AppBundle\Configuration\ReportConfiguration;
use WellCommerce\Bundle\AppBundle\Context\LineChartContext;

/**
 * Class DashboardController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class DashboardController extends AbstractController
{
    public function indexAction()
    {
        $salesSummary = $this->getSalesSummary();

        return $this->displayTemplate('index', [
                'salesChart'   => $this->getSalesChart(),
                'salesSummary' => $salesSummary->getSummary(),
                'currency'     => $this->getRequestHelper()->getCurrentCurrency()
            ]
        );
    }

    /**
     * @return LineChartContext
     */
    protected function getSalesChart()
    {
        $startDate     = Carbon::now()->startOfMonth();
        $endDate       = Carbon::now()->endOfMonth();
        $interval      = new DateInterval('P1D');
        $configuration = new ReportConfiguration($startDate, $endDate, $interval, 'd', 'Y-m-d');
        $report        = $this->get('sales_report.provider')->getReport($configuration);

        return new LineChartContext($report, $configuration);
    }

    protected function getSalesSummary()
    {
        $startDate     = Carbon::now()->startOfMonth();
        $endDate       = Carbon::now()->endOfMonth();
        $interval      = new DateInterval('P1D');
        $configuration = new ReportConfiguration($startDate, $endDate, $interval, 'Y-m-d', 'Y-m-d');
        $report        = $this->get('sales_report.provider')->getReport($configuration);

        return new SalesSummaryCalculator($report, $configuration);
    }
}
