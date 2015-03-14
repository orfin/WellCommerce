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
use WellCommerce\Bundle\DataSetBundle\Conditions\ConditionsCollection;
use WellCommerce\Bundle\DataSetBundle\Request\DataSetRequest;

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
        $results = $this->get('product.dataset.front')->getResults(new DataSetRequest([
            'limit'      => 10,
            'orderBy'    => 'name',
            'orderDir'   => 'asc',
            'conditions' => $this->getConditions(),
        ]));

        $this->get('category_products.provider')->setCurrentResource($results);

        return [
            'dataset' => $results
        ];
    }

    /**
     * Returns a collection of dynamic conditions
     *
     * @return ConditionsCollection
     */
    private function getConditions()
    {
        $conditions = new ConditionsCollection();
        $conditions->add(new Condition\Eq('category', $this->getCurrentCategoryId()));

        return $conditions;
    }

    /**
     * Returns current category id from provider service
     *
     * @return int
     */
    private function getCurrentCategoryId()
    {
        return $this->get('category.provider')->getCurrentResource()->getId();
    }
}
