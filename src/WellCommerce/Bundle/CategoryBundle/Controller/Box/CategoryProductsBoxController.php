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

namespace WellCommerce\Bundle\CategoryBundle\Controller\Box;

use WellCommerce\Bundle\CoreBundle\Controller\Box\AbstractBoxController;
use WellCommerce\Bundle\CoreBundle\Controller\Box\BoxControllerInterface;
use WellCommerce\Bundle\DataSetBundle\Conditions\Condition;

/**
 * Class CategoryProductsBoxController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 *
 * @Sensio\Bundle\FrameworkExtraBundle\Configuration\Template()
 */
class CategoryProductsBoxController extends AbstractBoxController implements BoxControllerInterface
{
    /**
     * {@inheritdoc}
     */
    public function indexAction()
    {
        $provider          = $this->getManager()->getProvider('category_products');
        $collectionBuilder = $provider->getCollectionBuilder();
        $requestHelper     = $this->getManager()->getRequestHelper();

        $dataset = $collectionBuilder->getDataSet([
            'limit'      => $requestHelper->getQueryAttribute('limit', 10),
            'order_by'   => $requestHelper->getQueryAttribute('order_by', 'name'),
            'order_dir'  => $requestHelper->getQueryAttribute('order_dir', 'asc'),
            'conditions' => $this->getManager()->getConditions(),
        ]);

        $provider->setCurrentResource($dataset);

        return [
            'dataset' => $dataset
        ];
    }
}
