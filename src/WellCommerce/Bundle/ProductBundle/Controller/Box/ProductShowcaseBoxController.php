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
use WellCommerce\Bundle\LayoutBundle\Collection\LayoutBoxSettingsCollection;

/**
 * Class ProductShowcaseBoxController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductShowcaseBoxController extends AbstractBoxController implements BoxControllerInterface
{
    /**
     * @var \WellCommerce\Bundle\ProductBundle\Manager\Front\ProductStatusManager
     */
    protected $manager;
    
    /**
     * {@inheritdoc}
     */
    public function indexAction(LayoutBoxSettingsCollection $boxSettings)
    {
        $requestHelper = $this->manager->getRequestHelper();

        $products = $this->get('product.dataset.front')->getResult('datagrid', [
            'limit'      => $requestHelper->getQueryBagParam('limit', 1),
            'order_by'   => $requestHelper->getQueryBagParam('orderBy', 'name'),
            'order_dir'  => $requestHelper->getQueryBagParam('orderDir', 'asc'),
            'conditions' => $this->manager->getStatusConditions($boxSettings->getParam('status')),
        ]);

        return $this->displayTemplate('index', [
            'dataset' => $products
        ]);
    }
}
