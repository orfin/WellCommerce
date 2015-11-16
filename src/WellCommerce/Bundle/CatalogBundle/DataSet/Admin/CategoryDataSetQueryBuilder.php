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

namespace WellCommerce\Bundle\CatalogBundle\DataSet\Admin;

use WellCommerce\Bundle\CommonBundle\Context\ShopContextInterface;
use WellCommerce\Bundle\DataSetBundle\Conditions\Condition\Eq;
use WellCommerce\Bundle\DataSetBundle\QueryBuilder\AbstractDataSetQueryBuilder;
use WellCommerce\Bundle\DataSetBundle\QueryBuilder\DataSetQueryBuilderInterface;

/**
 * Class CategoryDataSetQueryBuilder
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class CategoryDataSetQueryBuilder extends AbstractDataSetQueryBuilder implements DataSetQueryBuilderInterface
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

    protected function getConditions()
    {
        $conditions = parent::getConditions();

        if (null !== $this->context) {
            $conditions->add(new Eq('shop', $this->context->getCurrentShopIdentifier()));
        }

        return $conditions;
    }
}
