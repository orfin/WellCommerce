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
use WellCommerce\Bundle\DataSetBundle\Conditions\ConditionsCollection;
use WellCommerce\Bundle\LayoutBundle\Collection\LayoutBoxSettingsCollection;

/**
 * Class ProductShowcaseBoxController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductSearchBoxController extends AbstractBoxController implements BoxControllerInterface
{
    /**
     * @var \WellCommerce\Bundle\ProductBundle\Manager\Front\ProductSearchManager
     */
    protected $manager;

    /**
     * {@inheritdoc}
     */
    public function indexAction(LayoutBoxSettingsCollection $boxSettings)
    {
        $dataset       = $this->get('product.dataset.front');
        $conditions    = new ConditionsCollection();
        $requestHelper = $this->getRequestHelper();
        $offset        = $requestHelper->getAttributesBagParam('page', 1);
        $limit         = $this->manager->getRequestHelper()->getAttributesBagParam('limit', $boxSettings->getParam('per_page', 12));
        $conditions    = $this->manager->addSearchConditions($conditions);
        $conditions    = $this->getLayeredNavigationHelper()->addLayeredNavigationConditions($conditions);

        $products = $dataset->getResult('array', [
            'limit'      => $limit,
            'offset'     => ($offset * $limit) - $limit,
            'order_by'   => $requestHelper->getAttributesBagParam('orderBy', 'name'),
            'order_dir'  => $requestHelper->getAttributesBagParam('orderDir', 'asc'),
            'conditions' => $conditions,
        ]);


        return $this->displayTemplate('index', [
            'dataset' => $products,
        ]);
    }
}
