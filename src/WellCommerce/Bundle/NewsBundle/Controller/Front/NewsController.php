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

namespace WellCommerce\Bundle\NewsBundle\Controller\Front;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use WellCommerce\Bundle\CoreBundle\Controller\Front\AbstractFrontController;
use WellCommerce\Component\Breadcrumb\Model\Breadcrumb;

/**
 * Class NewsController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class NewsController extends AbstractFrontController
{
    /**
     * {@inheritdoc}
     */
    public function indexAction(Request $request) : Response
    {
        return $this->displayTemplate('index');
    }
    
    /**
     * {@inheritdoc}
     */
    public function viewAction(Request $request) : Response
    {
        $news = $this->findOr404($request);
        
        $this->getBreadcrumbProvider()->add(new Breadcrumb([
            'label' => $news->translate()->getTopic(),
        ]));
        
        return $this->displayTemplate('view', [
            'news' => $news,
            'metadata' => $news->translate()->getMeta()
        ]);
    }
    
    /**
     * Returns resource by ID parameter
     *
     * @param Request $request
     * @param array   $criteria
     *
     * @return mixed
     */
    protected function findOr404(Request $request, array $criteria = [])
    {
        // check whether request contains ID attribute
        if (!$request->attributes->has('id')) {
            throw new \LogicException('Request does not have "id" attribute set.');
        }
        
        $criteria['id'] = $request->attributes->get('id');
        
        if (null === $resource = $this->getManager()->getRepository()->findOneBy($criteria)) {
            throw new NotFoundHttpException(sprintf('Resource not found'));
        }
        
        return $resource;
    }
}
