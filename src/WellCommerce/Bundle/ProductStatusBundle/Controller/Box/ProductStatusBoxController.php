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

namespace WellCommerce\Bundle\ProductStatusBundle\Controller\Box;

use Symfony\Component\HttpFoundation\Response;
use WellCommerce\Bundle\CoreBundle\Controller\Box\AbstractBoxController;
use WellCommerce\Bundle\LayoutBundle\Collection\LayoutBoxSettingsCollection;
use WellCommerce\Bundle\ProductStatusBundle\Entity\ProductStatusInterface;
use WellCommerce\Component\DataSet\Conditions\Condition\Eq;
use WellCommerce\Component\DataSet\Conditions\ConditionsCollection;

/**
 * Class ProductShowcaseBoxController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductStatusBoxController extends AbstractBoxController
{
    public function indexAction(LayoutBoxSettingsCollection $boxSettings) : Response
    {
        $dataset       = $this->get('product.dataset.front');
        $requestHelper = $this->getRequestHelper();
        $limit         = $requestHelper->getQueryBagParam('limit', $boxSettings->getParam('per_page', 12));
        $status        = $this->getProductStatus($boxSettings->getParam('status'));
        $conditions    = $this->createConditionsCollection($status);
        $conditions    = $this->get('layered_navigation.helper')->addLayeredNavigationConditions($conditions);

        $products = $dataset->getResult('array', [
            'limit'      => $limit,
            'page'       => $requestHelper->getAttributesBagParam('page', 1),
            'order_by'   => $requestHelper->getAttributesBagParam('orderBy', 'name'),
            'order_dir'  => $requestHelper->getAttributesBagParam('orderDir', 'asc'),
            'conditions' => $conditions,
        ]);

        return $this->displayTemplate('index', [
            'dataset' => $products,
            'status'  => $status
        ]);
    }

    protected function getProductStatus(int $id = null) : ProductStatusInterface
    {
        if (null === $id) {
            $status = $this->getProductStatusStorage()->getCurrentProductStatus();
        } else {
            $status = $this->get('product_status.repository')->find($id);
        }

        return $status;
    }

    protected function createConditionsCollection(ProductStatusInterface $status) : ConditionsCollection
    {
        $conditions = new ConditionsCollection();
        $conditions->add(new Eq('status', $status->getId()));

        return $conditions;
    }
}
