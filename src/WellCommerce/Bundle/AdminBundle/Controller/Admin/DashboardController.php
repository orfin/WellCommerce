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
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
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
    public function indexAction(): Response
    {
        return $this->displayTemplate('index', [
            'reviews'      => $this->getReviews(),
            'orders'       => $this->getOrders(),
            'clients'      => $this->getClients(),
            'carts'        => $this->getCarts(),
        ]);
    }
    
    protected function getReviews(): array
    {
        return $this->get('review.repository')->findBy([
            'enabled' => true,
        ], ['createdAt' => 'desc'], 10);
    }
    
    protected function getOrders(): array
    {
        return $this->get('order.repository')->findBy([
            'confirmed' => true,
            'shop'      => $this->getShopStorage()->getCurrentShop(),
        ], ['createdAt' => 'desc'], 10);
    }
    
    protected function getClients(): array
    {
        return $this->get('client.repository')->findBy([
            'shop' => $this->getShopStorage()->getCurrentShop(),
        ], ['createdAt' => 'desc'], 10);
    }
    
    protected function getCarts(): Collection
    {
        $criteria = new Criteria();
        $criteria->where($criteria->expr()->eq('confirmed', false));
        $criteria->andWhere($criteria->expr()->eq('shop', $this->getShopStorage()->getCurrentShop()));
        $criteria->andWhere($criteria->expr()->neq('client', null));
        $criteria->andWhere($criteria->expr()->gt('productTotal.quantity', 0));
        $criteria->orderBy(['createdAt' => 'desc']);
        $criteria->setMaxResults(30);
        
        return $this->get('order.repository')->matching($criteria);
    }
}
