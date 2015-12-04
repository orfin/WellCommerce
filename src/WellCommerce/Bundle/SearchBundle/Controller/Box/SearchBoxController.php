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

namespace WellCommerce\Bundle\SearchBundle\Controller\Box;

use WellCommerce\Bundle\LayoutBundle\Collection\LayoutBoxSettingsCollection;
use WellCommerce\Component\DataSet\Conditions\ConditionsCollection;
use WellCommerce\Bundle\CoreBundle\Controller\Box\AbstractBoxController;

/**
 * Class SearchBoxController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class SearchBoxController extends AbstractBoxController
{
    /**
     * @var \WellCommerce\Bundle\SearchBundle\Manager\Front\SearchManager
     */
    protected $manager;

    /**
     * {@inheritdoc}
     */
    public function indexAction(LayoutBoxSettingsCollection $boxSettings)
    {
        $dataset       = $this->get('product_search.dataset.front');
        $conditions    = new ConditionsCollection();
        $requestHelper = $this->getRequestHelper();
        $limit         = $this->manager->getRequestHelper()->getAttributesBagParam('limit', $boxSettings->getParam('per_page', 12));
        $conditions    = $this->manager->addSearchConditions($conditions);
        $conditions    = $this->get('layered_navigation.helper')->addLayeredNavigationConditions($conditions);

        $products = $dataset->getResult('array', [
            'limit'      => $limit,
            'page'       => $requestHelper->getAttributesBagParam('page', 1),
            'order_by'   => $requestHelper->getAttributesBagParam('orderBy', 'score'),
            'order_dir'  => $requestHelper->getAttributesBagParam('orderDir', 'asc'),
            'conditions' => $conditions,
        ]);

        return $this->displayTemplate('index', [
            'dataset' => $products,
        ]);
    }
}
