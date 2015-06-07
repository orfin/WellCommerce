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

namespace WellCommerce\Bundle\ProductBundle\Controller\Box;

use WellCommerce\Bundle\CoreBundle\Controller\Box\AbstractBoxController;
use WellCommerce\Bundle\CoreBundle\Controller\Box\BoxControllerInterface;
use WellCommerce\Bundle\DataSetBundle\Conditions\Condition\Eq;
use WellCommerce\Bundle\DataSetBundle\Conditions\ConditionsCollection;

/**
 * Class ProductShowcaseBoxController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 *
 * @Sensio\Bundle\FrameworkExtraBundle\Configuration\Template()
 */
class ProductStatusBoxController extends AbstractBoxController implements BoxControllerInterface
{
    /**
     * {@inheritdoc}
     */
    public function indexAction()
    {
        $productProvider       = $this->getManager()->getProvider('product');
        $collectionBuilder     = $productProvider->getCollectionBuilder();
        $requestHelper         = $this->getManager()->getRequestHelper();

        $dataset = $collectionBuilder->getDataSet([
            'limit'      => $requestHelper->getQueryAttribute('limit', $this->getBoxParam('per_page', 12)),
            'order_by'   => $requestHelper->getQueryAttribute('order_by', 'price'),
            'order_dir'  => $requestHelper->getQueryAttribute('order_dir', 'asc'),
            'conditions' => $this->getConditions($this->getCurrentStatus()),
        ]);

        return [
            'dataset' => $dataset
        ];
    }

    /**
     * Return additional conditions for QueryBuilder
     *
     * @return ConditionsCollection
     */
    protected function getConditions($status)
    {
        $conditions = new ConditionsCollection();
        $conditions->add(new Eq('status', $status));

        return $conditions;
    }

    /**
     * Returns current status from provider or from box settings
     *
     * @return int
     */
    protected function getCurrentStatus()
    {
        $productStatusProvider = $this->getManager()->getProductStatusProvider();
        $currentStatus         = $productStatusProvider->getCurrentProductStatus();
        if (null === $currentStatus) {
            $status = $this->getBoxParam('status');
        } else {
            $status = $productStatusProvider->getCurrentProductStatusId();
        }

        return $status;
    }
}
