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
use WellCommerce\Bundle\ClientBundle\Entity\ClientInterface;
use WellCommerce\Bundle\OrderBundle\Entity\OrderInterface;
use WellCommerce\Bundle\ReportBundle\Configuration\ReportConfiguration;
use WellCommerce\Bundle\ReportBundle\Data\ReportRow;
use WellCommerce\Bundle\ReportBundle\Data\ReportRowCollection;

/**
 * Class ClientReportProvider
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ClientReportProvider extends AbstractReportProvider implements ReportProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function getReport(ReportConfiguration $configuration)
    {
        $criteria   = $this->getCriteria($configuration);
        $collection = $this->repository->matching($criteria);
        $report     = new ReportRowCollection();

        $collection->map(function (ClientInterface $client) use ($report) {
            $ordersTotal = $this->calculateOrdersAmountForClient($client);
            $identifier  = $client->getFirstName() . ' ' . $client->getLastName();
            $report->add(new ReportRow($identifier, $ordersTotal));
        });

        return $report;
    }

    /**
     * Calculates client's orders total value
     *
     * @param ClientInterface $client
     *
     * @return int|float
     */
    protected function calculateOrdersAmountForClient(ClientInterface $client)
    {
        $total = 0;
        $client->getOrders()->map(function (OrderInterface $order) use (&$total) {
            $total += $this->convertAmount($order);
        });

        return $total;
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
