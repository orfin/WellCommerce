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

namespace WellCommerce\Bundle\SearchBundle\Controller\Front;

use WellCommerce\Bundle\CoreBundle\Controller\Front\AbstractFrontController;
use WellCommerce\Bundle\CoreBundle\Service\Breadcrumb\BreadcrumbItem;
use WellCommerce\Component\DataSet\Conditions\ConditionsCollection;

/**
 * Class SearchController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class SearchController extends AbstractFrontController
{
    /**
     * @var \WellCommerce\Bundle\SearchBundle\Manager\Front\SearchManager
     */
    protected $manager;

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

    public function viewAction()
    {
        $requestHelper = $this->getRequestHelper();
        $phrase        = $requestHelper->getAttributesBagParam('phrase');
        if (strlen($phrase) < $this->container->getParameter('search_term_min_length')) {
            $liveSearchContent = '';
        } else {
            $dataset    = $this->get('product_search.dataset.front');
            $conditions = new ConditionsCollection();
            $conditions = $this->manager->addSearchConditions($conditions);
            $conditions = $this->get('layered_navigation.helper')->addLayeredNavigationConditions($conditions);

            $products = $dataset->getResult('array', [
                'limit'      => 20,
                'page'       => 1,
                'order_by'   => 'score',
                'order_dir'  => 'asc',
                'conditions' => $conditions,
            ]);

            $liveSearchContent = $this->renderView('WellCommerceSearchBundle:Front/Search:view.html.twig', [
                'dataset' => $products,
            ]);
        }

        return $this->jsonResponse([
            'liveSearchContent' => $liveSearchContent
        ]);
    }
}
