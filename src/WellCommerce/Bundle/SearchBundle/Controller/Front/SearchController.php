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
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use WellCommerce\Bundle\CoreBundle\Controller\Front\AbstractFrontController;
use WellCommerce\Bundle\SearchBundle\Manager\SearchEngineManager;
use WellCommerce\Component\Breadcrumb\Model\Breadcrumb;
use WellCommerce\Component\DataSet\Conditions\ConditionsCollection;

/**
 * Class SearchController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class SearchController extends AbstractFrontController
{
    public function indexAction(string $index, Request $request) : Response
    {
        $phrase  = $request->get('phrase');
        $results = $this->search($index, $request);
        
        $this->getBreadcrumbProvider()->add(new Breadcrumb([
            'label' => $this->trans('search.heading.index')
        ]));
        
        $this->getBreadcrumbProvider()->add(new Breadcrumb([
            'label' => $phrase
        ]));
        
        return $this->displayTemplate('index', [
            'phrase'  => $phrase,
            'results' => $results,
        ]);
    }
    
    public function viewAction(string $index, Request $request) : JsonResponse
    {
        $liveSearchContent = '';
        $result            = [];
        $phrase            = $request->get('phrase');
        
        if (strlen($phrase) >= $this->container->getParameter('search_term_min_length')) {
            $result = $this->search($index, $request);
            
            $dataset    = $this->get('search.dataset.front');
            $conditions = new ConditionsCollection();
            $conditions = $this->get('layered_navigation.helper')->addLayeredNavigationConditions($conditions);
            
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
        }
        
        return $this->jsonResponse([
            'liveSearchContent' => $liveSearchContent,
            'result'            => $result,
            'total'             => count($result)
        ]);
    }
    
    protected function search(string $index, Request $request) : array
    {
        print_r($request->get('fields'));
        die();
        $queryBuilder = $this->getSearchEngineManager()->getQueryBuilder();
        $queryBuilder->buildFromRequest($request);
        
        return $this->getSearchEngineManager()->search($queryBuilder, $index);
    }
    
    private function getSearchEngineManager() : SearchEngineManager
    {
        return $this->get('search.engine.manager');
    }
}
