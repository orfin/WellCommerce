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

namespace WellCommerce\Bundle\PaymentBundle\DataSet\Front;

use Doctrine\ORM\QueryBuilder;
use WellCommerce\Bundle\PaymentBundle\DataSet\Admin\PaymentMethodDataSet as BaseDataSet;
use WellCommerce\Bundle\PaymentBundle\Entity\PaymentMethod;
use WellCommerce\Bundle\ShippingBundle\Entity\ShippingMethod;
use WellCommerce\Component\DataSet\Cache\CacheOptions;
use WellCommerce\Component\DataSet\Configurator\DataSetConfiguratorInterface;

/**
 * Class PaymentMethodDataSet
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class PaymentMethodDataSet extends BaseDataSet
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(DataSetConfiguratorInterface $configurator)
    {
        parent::configureOptions($configurator);
        
        $configurator->setCacheOptions(new CacheOptions(true, 3600, [
            PaymentMethod::class,
            ShippingMethod::class,
        ]));
    }
    
    protected function createQueryBuilder(): QueryBuilder
    {
        $queryBuilder = $this->repository->getQueryBuilder();
        $queryBuilder->leftJoin('payment_method.translations', 'payment_method_translation');
        $queryBuilder->groupBy('payment_method.id');
        
        return $queryBuilder;
    }
}
