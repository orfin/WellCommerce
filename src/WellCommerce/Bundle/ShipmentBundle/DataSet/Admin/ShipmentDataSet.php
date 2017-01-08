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

namespace WellCommerce\Bundle\ShipmentBundle\DataSet\Admin;

use Doctrine\ORM\QueryBuilder;
use WellCommerce\Bundle\CoreBundle\DataSet\AbstractDataSet;
use WellCommerce\Component\DataSet\Configurator\DataSetConfiguratorInterface;

/**
 * Class ShipmentDataSet
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class ShipmentDataSet extends AbstractDataSet
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(DataSetConfiguratorInterface $configurator)
    {
        $configurator->setColumns([
            'id'            => 'shipment.id',
            'orderNumber'   => 'orders.number',
            'guid'          => 'shipment.guid',
            'packageNumber' => 'shipment.packageNumber',
            'courier'       => 'shipment.courier',
            'createdAt'     => 'shipment.createdAt',
        ]);
        
        $configurator->setColumnTransformers([
            'createdAt' => $this->manager->createTransformer('date', ['format' => 'Y-m-d H:i:s']),
        ]);
    }
    
    protected function createQueryBuilder(): QueryBuilder
    {
        $queryBuilder = $this->repository->getQueryBuilder();
        $queryBuilder->leftJoin('shipment.order', 'orders');
        $queryBuilder->groupBy('shipment.id');
        
        return $queryBuilder;
    }
}
