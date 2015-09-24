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

namespace WellCommerce\Bundle\CategoryBundle\Controller\Front;

use Symfony\Component\HttpFoundation\Request;
use WellCommerce\Bundle\CoreBundle\Controller\Front\AbstractFrontController;
use WellCommerce\Bundle\CoreBundle\Controller\Front\FrontControllerInterface;
use WellCommerce\Bundle\WebBundle\Breadcrumb\BreadcrumbItem;

/**
 * Class CategoryController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CategoryController extends AbstractFrontController implements FrontControllerInterface
{
    /**
     * {@inheritdoc}
     */
    public function indexAction(Request $request)
    {
        $category = $this->findOr404($request, [
            'enabled' => 1
        ]);

        $this->addBreadCrumbItem(new BreadcrumbItem([
            'name' => $category->translate()->getName(),
        ]));

        $this->manager->getCategoryProvider()->setCurrentCategory($category);

        return $this->displayTemplate('index', [
            'category' => $category
        ]);
    }
}
