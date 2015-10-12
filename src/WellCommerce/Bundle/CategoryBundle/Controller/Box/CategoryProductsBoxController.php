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
use WellCommerce\Bundle\LayoutBundle\Collection\LayoutBoxSettingsCollection;

/**
 * Class CategoryProductsBoxController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CategoryProductsBoxController extends AbstractBoxController implements BoxControllerInterface
{
    /**
     * @var \WellCommerce\Bundle\CategoryBundle\Manager\Front\CategoryManager
     */
    protected $manager;

    /**
     * {@inheritdoc}
     */
    public function indexAction(LayoutBoxSettingsCollection $boxSettings)
    {
        $dataset       = $this->get('product.dataset.front');
        $requestHelper = $this->manager->getRequestHelper();
        $limit         = $requestHelper->getCurrentLimit($boxSettings->getParam('per_page', 12));
        $offset        = $requestHelper->getCurrentOffset($limit);

        $products = $dataset->getResult('datagrid', [
            'limit'      => $limit,
            'offset'     => $offset,
            'order_by'   => $requestHelper->getQueryAttribute('order_by', 'name'),
            'order_dir'  => $requestHelper->getQueryAttribute('order_dir', 'asc'),
            'conditions' => $this->manager->getCurrentCategoryConditions(),
        ]);

        return $this->displayTemplate('index', [
            'dataset' => $products
        ]);
    }
}
