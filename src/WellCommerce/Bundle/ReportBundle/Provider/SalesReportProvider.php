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

use Doctrine\Common\Collections\Criteria;
use WellCommerce\Bundle\ReportBundle\Configuration\ReportConfiguration;
use WellCommerce\Bundle\AppBundle\Data\ReportRow;
use WellCommerce\Bundle\AppBundle\Data\ReportRowCollection;
use WellCommerce\Bundle\OrderBundle\Entity\OrderInterface;

/**
 * Class SalesReportDataProvider
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class SalesReportProvider extends AbstractReportProvider implements ReportProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function getReport(ReportConfiguration $configuration)
    {
        $criteria   = $this->getCriteria($configuration);
        $collection = $this->repository->matching($criteria);
        $report     = new ReportRowCollection();

        $collection->map(function (OrderInterface $order) use ($configuration, $report) {
            $date   = $order->getCreatedAt()->format($configuration->getGroupByDateFormat());
            $amount = $this->convertAmount($order);
            $report->add(new ReportRow($date, $amount));
        });

        return $report;
    }

    /**
     * Returns the report's criteria
     *
     * @param ReportConfiguration $configuration
     *
     * @return Criteria
     */
    protected function getCriteria(ReportConfiguration $configuration)
    {
        $criteria = new Criteria();
        $criteria->where($criteria->expr()->gte('createdAt', $configuration->getStartDate()));
        $criteria->andWhere($criteria->expr()->lte('createdAt', $configuration->getEndDate()));

        return $criteria;
    }
}
