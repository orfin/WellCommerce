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

/**
 * Class ProductShowcaseBoxController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductShowcaseBoxController extends AbstractBoxController
{
    /**
     * @var \WellCommerce\Bundle\ProductStatusBundle\Manager\Front\ProductStatusManager
     */
    protected $manager;
    
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
            $category['dataset'] = $this->manager->getShowcaseCategoryProducts($category['id'], $boxSettings->getParam('status'));
        }

        return $this->displayTemplate('index', [
            'showcase' => $categories,
        ]);
    }
}
