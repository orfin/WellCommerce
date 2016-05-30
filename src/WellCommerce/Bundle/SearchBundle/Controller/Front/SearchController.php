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

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use WellCommerce\Bundle\CoreBundle\Controller\Front\AbstractFrontController;
use WellCommerce\Bundle\SearchBundle\Manager\SearchManagerInterface;
use WellCommerce\Component\Breadcrumb\Model\Breadcrumb;
use WellCommerce\Component\DataSet\Conditions\ConditionsCollection;
use WellCommerce\Component\Search\Request\SearchRequestInterface;

/**
 * Class SearchController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class SearchController extends AbstractFrontController
{
    public function indexAction(SearchRequestInterface $searchRequest) : Response
    {
        $this->getSearchManager()->search($searchRequest);

        $this->getBreadcrumbProvider()->add(new Breadcrumb([
            'label' => $this->trans('search.heading.index')
        ]));
        
        $this->getBreadcrumbProvider()->add(new Breadcrumb([
            'label' => $searchRequest->getPhrase()
        ]));
        
        return $this->displayTemplate('index', [
            'phrase' => $searchRequest->getPhrase()
        ]);
    }

    public function advancedSearchAction() : Response
    {

    }

    public function quickSearchAction(SearchRequestInterface $searchRequest) : JsonResponse
    {
        $identifiers = $this->getSearchManager()->search($searchRequest);
        $dataset     = $this->get('search.dataset.front');
        $conditions  = new ConditionsCollection();
        $conditions  = $this->get('layered_navigation.helper')->addLayeredNavigationConditions($conditions);

        $products = $dataset->getResult('array', [
            'limit'      => 5,
            'page'       => 1,
            'order_by'   => 'score',
            'order_dir'  => 'asc',
            'conditions' => $conditions,
        ]);

        $liveSearchContent = $this->renderView('WellCommerceSearchBundle:Front/Search:view.html.twig', [
            'dataset' => $products,
        ]);

        return $this->jsonResponse([
            'liveSearchContent' => $liveSearchContent,
            'total'             => count($identifiers)
        ]);
    }
    
    private function getSearchManager() : SearchManagerInterface
    {
        return $this->get('search.manager');
    }
}
