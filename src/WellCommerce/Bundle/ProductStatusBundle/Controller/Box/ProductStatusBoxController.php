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

use WellCommerce\Bundle\LayoutBundle\Collection\LayoutBoxSettingsCollection;
use WellCommerce\Bundle\CoreBundle\Controller\Box\AbstractBoxController;

/**
 * Class ProductShowcaseBoxController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductStatusBoxController extends AbstractBoxController
{
    /**
     * @var \WellCommerce\Bundle\ProductStatusBundle\Manager\Front\ProductStatusManager
     */
    protected $manager;
    
    /**
     * {@inheritdoc}
     */
    public function indexAction(LayoutBoxSettingsCollection $boxSettings)
    {
        $dataset       = $this->get('product.dataset.front');
        $requestHelper = $this->manager->getRequestHelper();
        $limit         = $requestHelper->getQueryBagParam('limit', $boxSettings->getParam('per_page', 12));
        $conditions    = $this->manager->getStatusConditions($boxSettings->getParam('status'));
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
        ]);
    }
}
