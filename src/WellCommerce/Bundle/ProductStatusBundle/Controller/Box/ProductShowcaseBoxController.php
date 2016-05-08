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
use WellCommerce\Component\DataSet\Conditions\Condition\Eq;
use WellCommerce\Component\DataSet\Conditions\ConditionsCollection;

/**
 * Class ProductShowcaseBoxController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductShowcaseBoxController extends AbstractBoxController
{
    public function indexAction(LayoutBoxSettingsCollection $boxSettings) : Response
    {
        $categories = $this->get('category.dataset.front')->getResult('array', [
            'limit'     => 5,
            'order_by'  => 'name',
            'order_dir' => 'asc'
        ], [
            'pagination' => false
        ]);
        
        foreach ($categories['rows'] as &$category) {
            $conditions = $this->createConditionsCollection($boxSettings->getParam('status'), $category['id']);
            
            $category['dataset'] = $this->get('product.dataset.front')->getResult('array', [
                'limit'      => 10,
                'order_by'   => 'name',
                'order_dir'  => 'asc',
                'conditions' => $conditions
            ]);
        }
        
        return $this->displayTemplate('index', [
            'showcase' => $categories,
        ]);
    }
    
    protected function createConditionsCollection(int $status, int $categoryId) : ConditionsCollection
    {
        $conditions = new ConditionsCollection();
        $conditions->add(new Eq('status', $status));
        $conditions->add(new Eq('category', $categoryId));
        
        return $conditions;
    }
}
