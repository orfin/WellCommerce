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

namespace WellCommerce\Bundle\ProductBundle\DataSet\Admin;

use WellCommerce\Bundle\ShopBundle\Storage\ShopStorageInterface;
use WellCommerce\Component\DataSet\Conditions\Condition\Eq;
use WellCommerce\Component\DataSet\Conditions\ConditionsCollection;
use WellCommerce\Component\DataSet\QueryBuilder\AbstractDataSetQueryBuilder;
use WellCommerce\Component\DataSet\Request\DataSetRequestInterface;

/**
 * Class ProductDataSetQueryBuilder
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductDataSetQueryBuilder extends AbstractDataSetQueryBuilder
{
    /**
     * @var ShopStorageInterface
     */
    protected $shopStorage;

    /**
     * @param ShopStorageInterface $shopStorage
     */
    public function setShopStorage(ShopStorageInterface $shopStorage)
    {
        $this->shopStorage = $shopStorage;
    }

    protected function getConditions(DataSetRequestInterface $request) : ConditionsCollection
    {
        $conditions = parent::getConditions($request);
        $conditions->add(new Eq('shop', $this->shopStorage->getCurrentShopIdentifier()));

        return $conditions;
    }
}
