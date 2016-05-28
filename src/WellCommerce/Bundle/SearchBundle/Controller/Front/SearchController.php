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

use Doctrine\Common\Util\Debug;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use WellCommerce\Bundle\CoreBundle\Controller\Front\AbstractFrontController;
use WellCommerce\Bundle\SearchBundle\Manager\SearchManagerInterface;
use WellCommerce\Component\Breadcrumb\Model\Breadcrumb;
use WellCommerce\Component\DataSet\Conditions\ConditionsCollection;
use WellCommerce\Bundle\SearchBundle\Type\IndexType;

/**
 * Class SearchController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class SearchController extends AbstractFrontController
{
    public function indexAction(IndexType $indexType, Request $request) : Response
    {
        $results = $this->getSearchManager()->search($indexType, $request);
        print_r($results);
        die();
        
        $this->search($index, $request);
        
        $this->getBreadcrumbProvider()->add(new Breadcrumb([
            'label' => $this->trans('search.heading.index')
        ]));
        
        $this->getBreadcrumbProvider()->add(new Breadcrumb([
            'label' => $request->get('phrase')
        ]));
        
        return $this->displayTemplate('index', [
            'phrase' => $request->get('phrase')
        ]);
    }

    public function advancedSearchAction() : Response {

    }

    public function quickSearchAction(IndexType $indexType, Request $request) : JsonResponse
    {
        echo $indexType->getName();
        die();
        
        $liveSearchContent = '';
        $identifiers       = [];
        $phrase            = $request->get('phrase');
        
        if (strlen($phrase) >= $this->container->getParameter('search_term_min_length')) {
            $identifiers = $this->search($index, $request);
            
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
            'total'             => count($identifiers)
        ]);
    }
    
    protected function search(string $index, Request $request) : array
    {
        $queryBuilder = $this->getSearchEngineManager()->getQueryBuilder();
        $queryBuilder->buildFromRequest($request);
        
        return $this->getSearchEngineManager()->search($queryBuilder, $index);
    }
    
    private function getSearchManager() : SearchManagerInterface
    {
        return $this->get('search.manager');
    }
}
