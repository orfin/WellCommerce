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

namespace WellCommerce\Bundle\AdminBundle\Controller\Admin;

use Carbon\Carbon;
use DateInterval;
use Symfony\Component\HttpFoundation\Response;
use WellCommerce\Bundle\CoreBundle\Controller\AbstractController;
use WellCommerce\Bundle\ReportBundle\Calculator\SalesSummaryCalculator;
use WellCommerce\Bundle\ReportBundle\Configuration\ReportConfiguration;
use WellCommerce\Bundle\ReportBundle\Context\LineChartContext;

/**
 * Class DashboardController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class DashboardController extends AbstractController
{
    public function indexAction() : Response
    {
        $salesSummary = $this->getSalesSummary();

        return $this->displayTemplate('index', [
            'salesChart'   => $this->getSalesChart(),
            'salesSummary' => $salesSummary->getSummary(),
            'currency'     => $this->getRequestHelper()->getCurrentCurrency()
        ]);
    }

    /**
     * @return LineChartContext
     */
    protected function getSalesChart() : LineChartContext
    {
        $startDate     = Carbon::now()->startOfMonth();
        $endDate       = Carbon::now()->endOfMonth();
        $interval      = new DateInterval('P1D');
        $configuration = new ReportConfiguration($startDate, $endDate, $interval, 'd', 'Y-m-d');
        $report        = $this->get('sales_report.provider')->getReport($configuration);

        return new LineChartContext($report, $configuration);
    }

    protected function getSalesSummary() : SalesSummaryCalculator
    {
        $startDate     = Carbon::now()->startOfMonth();
        $endDate       = Carbon::now()->endOfMonth();
        $interval      = new DateInterval('P1D');
        $configuration = new ReportConfiguration($startDate, $endDate, $interval, 'Y-m-d', 'Y-m-d');
        $report        = $this->get('sales_report.provider')->getReport($configuration);

        return new SalesSummaryCalculator($report, $configuration);
    }
}
