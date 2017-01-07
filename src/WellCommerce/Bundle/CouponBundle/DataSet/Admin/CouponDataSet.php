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

namespace WellCommerce\Bundle\CouponBundle\DataSet\Admin;

use Doctrine\ORM\QueryBuilder;
use WellCommerce\Bundle\CoreBundle\DataSet\AbstractDataSet;
use WellCommerce\Component\DataSet\Configurator\DataSetConfiguratorInterface;

/**
 * Class CouponDataSet
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class CouponDataSet extends AbstractDataSet
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(DataSetConfiguratorInterface $configurator)
    {
        $configurator->setColumns([
            'id'                => 'coupon.id',
            'name'              => 'coupon_translation.name',
            'code'              => 'coupon.code',
            'createdAt'         => 'coupon.createdAt',
            'validFrom'         => 'coupon.validFrom',
            'validTo'           => 'coupon.validTo',
            'currency'          => 'coupon.currency',
            'minimumOrderValue' => 'coupon.minimumOrderValue',
            'discount'          => 'IF_ELSE(coupon.modifierType = \'%\', CONCAT_WS(\'\', coupon.modifierValue, coupon.modifierType), CONCAT_WS(\' \', coupon.modifierValue, coupon.currency))',
        ]);
        
        $configurator->setColumnTransformers([
            'createdAt' => $this->getDataSetTransformer('date', ['format' => 'Y-m-d H:i:s']),
            'validFrom' => $this->getDataSetTransformer('date', ['format' => 'Y-m-d']),
            'validTo'   => $this->getDataSetTransformer('date', ['format' => 'Y-m-d']),
        ]);
    }
    
    protected function createQueryBuilder(): QueryBuilder
    {
        $queryBuilder = $this->repository->getQueryBuilder();
        $queryBuilder->groupBy('coupon.id');
        $queryBuilder->leftJoin('coupon.translations', 'coupon_translation');
        
        return $queryBuilder;
    }
}
