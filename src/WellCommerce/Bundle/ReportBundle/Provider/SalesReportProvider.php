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

namespace WellCommerce\Bundle\ReportBundle\Provider;

use DateInterval;
use DateTime;
use Doctrine\Common\Collections\Criteria;
use WellCommerce\Bundle\OrderBundle\Entity\OrderInterface;
use WellCommerce\Bundle\ReportBundle\Calculator\SalesSummaryCalculator;
use WellCommerce\Bundle\ReportBundle\Configuration\ReportConfiguration;
use WellCommerce\Bundle\ReportBundle\Context\LineChartContext;
use WellCommerce\Bundle\ReportBundle\Data\ReportRow;
use WellCommerce\Bundle\ReportBundle\Data\ReportRowCollection;

/**
 * Class SalesReportDataProvider
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class SalesReportProvider extends AbstractReportProvider implements ReportProviderInterface
{
    public function getSummary(DateTime $startDate, DateTime $endDate)
    {
        $interval      = new DateInterval('P1D');
        $configuration = new ReportConfiguration($startDate, $endDate, $interval, 'Y-m-d', 'Y-m-d');
        $report        = $this->getReport($configuration);
        
        return new SalesSummaryCalculator($report, $configuration);
    }
    
    public function getChartData(DateTime $startDate, DateTime $endDate): LineChartContext
    {
        $groupByFormat = 'd';
        if ($startDate->format('Ym') !== $endDate->format('Ym')) {
            $groupByFormat = 'm';
        }
        
        $interval      = new DateInterval('P1D');
        $configuration = new ReportConfiguration($startDate, $endDate, $interval, $groupByFormat, 'Y-m-d');
        $report        = $this->getReport($configuration);
        
        return new LineChartContext($report, $configuration);
    }
    
    private function getReport(ReportConfiguration $configuration): ReportRowCollection
    {
        $criteria   = $this->createCriteria($configuration);
        $collection = $this->repository->matching($criteria);
        $report     = new ReportRowCollection();
        
        $collection->map(function (OrderInterface $order) use ($configuration, $report) {
            $date   = $order->getCreatedAt()->format($configuration->getGroupByDateFormat());
            $amount = $this->convertAmount($order);
            $report->add(new ReportRow($date, $amount));
        });
        
        return $report;
    }
    
    private function createCriteria(ReportConfiguration $configuration): Criteria
    {
        $criteria = new Criteria();
        $criteria->where($criteria->expr()->gte('createdAt', $configuration->getStartDate()));
        $criteria->andWhere($criteria->expr()->lte('createdAt', $configuration->getEndDate()));
        $criteria->andWhere($criteria->expr()->eq('confirmed', true));
        $criteria->andWhere($criteria->expr()->eq('shop', $this->getShopStorage()->getCurrentShop()));
        
        return $criteria;
    }
}
