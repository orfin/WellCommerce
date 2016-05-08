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

use Symfony\Component\HttpFoundation\Response;
use WellCommerce\Bundle\CoreBundle\Controller\Box\AbstractBoxController;
use WellCommerce\Bundle\LayoutBundle\Collection\LayoutBoxSettingsCollection;
use WellCommerce\Component\DataSet\Conditions\ConditionsCollection;

/**
 * Class SearchBoxController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class SearchBoxController extends AbstractBoxController
{
    /**
     * {@inheritdoc}
     */
    public function indexAction(LayoutBoxSettingsCollection $boxSettings) : Response
    {
        $dataset       = $this->get('search.dataset.front');
        $conditions    = $this->getConditions();
        $requestHelper = $this->getRequestHelper();
        $limit         = $this->getRequestHelper()->getAttributesBagParam('limit', $boxSettings->getParam('per_page', 12));

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

    protected function getConditions() : ConditionsCollection
    {
        $conditions = new ConditionsCollection();
        $conditions = $this->manager->addSearchConditions($conditions);
        $conditions = $this->get('layered_navigation.helper')->addLayeredNavigationConditions($conditions);

        return $conditions;
    }
}
