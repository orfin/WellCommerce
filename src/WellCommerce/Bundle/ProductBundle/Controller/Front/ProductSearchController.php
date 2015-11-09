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

namespace WellCommerce\Bundle\ProductBundle\Controller\Front;

use WellCommerce\Bundle\CoreBundle\Controller\Front\AbstractFrontController;
use WellCommerce\Bundle\CoreBundle\Controller\Front\FrontControllerInterface;
use WellCommerce\Bundle\WebBundle\Breadcrumb\BreadcrumbItem;

/**
 * Class ProductSearchController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductSearchController extends AbstractFrontController implements FrontControllerInterface
{
    /**
     * {@inheritdoc}
     */
    public function indexAction()
    {
        $requestHelper = $this->manager->getRequestHelper();
        $phrase        = $requestHelper->getAttributesBagParam('phrase');

        $this->addBreadCrumbItem(new BreadcrumbItem([
            'name' => $this->trans('product_search.heading.index')
        ]));

        $this->addBreadCrumbItem(new BreadcrumbItem([
            'name' => $phrase
        ]));

        return $this->displayTemplate('index', [
            'phrase' => $phrase,
        ]);
    }

    protected function getSortOptions()
    {
        $sorting = [
            'name'       => [
                'asc'  => [
                    'label' => $this->trans('product.options.order_by.name.asc'),
                ],
                'desc' => [
                    'label' => $this->trans('product.options.order_by.name.desc')
                ],
            ],
            'finalPrice' => [
                'asc'  => [
                    'label' => $this->trans('product.options.order_by.final_price.asc')
                ],
                'desc' => [
                    'label' => $this->trans('product.options.order_by.final_price.desc')
                ],
            ],
            'score'      => [
                'asc' => [
                    'label' => $this->trans('product.options.order_by.score.asc')
                ],
            ],
        ];

        foreach ($sorting as $column => $directions) {

        }
    }
}
