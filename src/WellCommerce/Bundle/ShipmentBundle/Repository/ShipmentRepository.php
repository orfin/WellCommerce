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
namespace WellCommerce\Bundle\ShipmentBundle\Repository;

use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\QueryBuilder;
use WellCommerce\Bundle\CoreBundle\Repository\EntityRepository;
use WellCommerce\Bundle\ShippingBundle\Entity\ShipmentInterface;

/**
 * Class ShipmentRepository
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ShipmentRepository extends EntityRepository implements ShipmentRepositoryInterface
{
    public function getDataSetQueryBuilder() : QueryBuilder
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->leftJoin('shipment.order', 'orders');
        $queryBuilder->groupBy('shipment.id');
        
        return $queryBuilder;
    }
}
