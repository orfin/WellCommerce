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

namespace WellCommerce\AppBundle\DataSet\Admin;

use WellCommerce\AppBundle\Service\Shop\Context\ShopContextInterface;
use WellCommerce\Component\DataSet\Conditions\Condition\Eq;
use WellCommerce\Component\DataSet\QueryBuilder\AbstractDataSetQueryBuilder;

/**
 * Class CategoryDataSetQueryBuilder
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class CategoryDataSetQueryBuilder extends AbstractDataSetQueryBuilder
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
