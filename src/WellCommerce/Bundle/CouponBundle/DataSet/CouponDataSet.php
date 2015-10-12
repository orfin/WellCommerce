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

namespace WellCommerce\Bundle\CouponBundle\DataSet;

use WellCommerce\Bundle\CoreBundle\DataSet\AbstractDataSet;
use WellCommerce\Bundle\DataSetBundle\Configurator\DataSetConfiguratorInterface;
use WellCommerce\Bundle\DataSetBundle\Transformer\DateTransformer;

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
            'id'        => 'coupon.id',
            'name'      => 'coupon_translation.name',
            'code'      => 'coupon.code',
            'createdAt' => 'coupon.createdAt',
            'validFrom' => 'coupon.validFrom',
            'validTo'   => 'coupon.validTo',
            'discount'  => 'IF_ELSE(coupon.modifierType = \'%\', CONCAT_WS(\'\', coupon.modifierValue, coupon.modifierType), CONCAT_WS(\' \', coupon.modifierValue, coupon.currency))',
        ]);

        $configurator->setTransformers([
            'createdAt' => new DateTransformer('Y-m-d H:i:s'),
            'validFrom' => new DateTransformer('Y-m-d'),
            'validTo'   => new DateTransformer('Y-m-d'),
        ]);
    }
}
