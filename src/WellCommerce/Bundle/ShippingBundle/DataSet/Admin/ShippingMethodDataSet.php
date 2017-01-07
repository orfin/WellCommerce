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

namespace WellCommerce\Bundle\ShippingBundle\DataSet\Admin;

use Doctrine\ORM\QueryBuilder;
use WellCommerce\Bundle\CoreBundle\DataSet\AbstractDataSet;
use WellCommerce\Component\DataSet\Configurator\DataSetConfiguratorInterface;

/**
 * Class ShippingMethodDataSet
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class ShippingMethodDataSet extends AbstractDataSet
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(DataSetConfiguratorInterface $configurator)
    {
        $configurator->setColumns([
            'id'         => 'shipping_method.id',
            'name'       => 'shipping_method_translation.name',
            'calculator' => 'shipping_method.calculator',
            'hierarchy'  => 'shipping_method.hierarchy',
        ]);
    }
    
    protected function createQueryBuilder(): QueryBuilder
    {
        $queryBuilder = $this->repository->getQueryBuilder();
        $queryBuilder->groupBy('shipping_method.id');
        $queryBuilder->leftJoin('shipping_method.translations', 'shipping_method_translation');
        
        return $queryBuilder;
    }
}
