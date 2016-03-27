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

namespace WellCommerce\Bundle\ProducerBundle\DataSet\Admin;

use WellCommerce\Bundle\ShopBundle\Context\ShopContextInterface;
use WellCommerce\Component\DataSet\Conditions\Condition\Eq;
use WellCommerce\Component\DataSet\Conditions\ConditionsCollection;
use WellCommerce\Component\DataSet\QueryBuilder\AbstractDataSetQueryBuilder;
use WellCommerce\Component\DataSet\Request\DataSetRequestInterface;

/**
 * Class ProducerDataSetQueryBuilder
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProducerDataSetQueryBuilder extends AbstractDataSetQueryBuilder
{
    /**
     * @var ShopContextInterface
     */
    protected $context;

    /**
     * @param ShopContextInterface $context
     */
    public function setShopContext(ShopContextInterface $context)
    {
        $this->context = $context;
    }

    protected function getConditions(DataSetRequestInterface $request) : ConditionsCollection
    {
        $conditions = parent::getConditions($request);
        $conditions->add(new Eq('shop', $this->context->getCurrentShopIdentifier()));

        return $conditions;
    }
}
