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

namespace WellCommerce\Bundle\ProducerBundle\Controller\Box;

use Symfony\Component\HttpFoundation\Response;
use WellCommerce\Bundle\CoreBundle\Controller\Box\AbstractBoxController;
use WellCommerce\Bundle\LayoutBundle\Collection\LayoutBoxSettingsCollection;
use WellCommerce\Component\DataSet\Conditions\Condition\Eq;
use WellCommerce\Component\DataSet\Conditions\ConditionsCollection;

/**
 * Class ProducerProductsBoxController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProducerProductsBoxController extends AbstractBoxController
{
    /**
     * {@inheritdoc}
     */
    public function indexAction(LayoutBoxSettingsCollection $boxSettings) : Response
    {
        $dataset       = $this->get('product.dataset.front');
        $requestHelper = $this->getRequestHelper();
        $limit         = $requestHelper->getAttributesBagParam('limit', $boxSettings->getParam('per_page', 12));
        $conditions    = $this->getCurrentProducerConditions();
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

    /**
     * @return ConditionsCollection
     */
    protected function getCurrentProducerConditions() : ConditionsCollection
    {
        $conditions = new ConditionsCollection();
        $conditions->add(new Eq('producerId', $this->getProducerStorage()->getCurrentProducerIdentifier()));

        return $conditions;
    }
}
