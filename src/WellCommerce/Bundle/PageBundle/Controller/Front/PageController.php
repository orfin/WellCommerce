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

namespace WellCommerce\Bundle\PageBundle\Controller\Front;

use Symfony\Component\HttpFoundation\Request;
use WellCommerce\Bundle\CoreBundle\Controller\Front\AbstractFrontController;
use WellCommerce\Bundle\CoreBundle\Service\Breadcrumb\BreadcrumbItem;

/**
 * Class PageController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class PageController extends AbstractFrontController
{
    /**
     * {@inheritdoc}
     */
    public function indexAction(Request $request)
    {
        $page = $this->findOr404($request);

        if (null !== $page->getParent()) {
            $this->addBreadCrumbItem(new BreadcrumbItem([
                'name' => $page->getParent()->translate()->getName(),
            ]));
        }
        
        $this->addBreadCrumbItem(new BreadcrumbItem([
            'name' => $page->translate()->getName(),
        ]));

        return $this->displayTemplate('index', [
            'page' => $page
        ]);
    }
}
