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

namespace WellCommerce\Bundle\ReportBundle\Controller\Admin;

use Doctrine\Common\Collections\Criteria;
use WellCommerce\Bundle\CoreBundle\Controller\Admin\AbstractAdminController;

/**
 * Class SalesReportController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class SalesReportController extends AbstractAdminController
{
    /**
     * @var \WellCommerce\Bundle\ReportBundle\Manager\Admin\SalesReportManagerInterface
     */
    protected $manager;

    public function indexAction()
    {
        $criteria = new Criteria();
        $criteria->where($criteria->expr()->gte('createdAt', (new \DateTime())->modify('first day of this month 00:00:00')));
        $criteria->andWhere($criteria->expr()->lte('createdAt', (new \DateTime())->modify('last day of this month 23:59:59')));

        $summaryStats = $this->manager->getSummaryStats($criteria);

        print_r($summaryStats);
        die();

        return $this->displayTemplate('index');
    }
}
