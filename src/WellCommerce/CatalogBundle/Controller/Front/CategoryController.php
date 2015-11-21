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

namespace WellCommerce\CatalogBundle\Controller\Front;

use WellCommerce\CatalogBundle\Entity\CategoryInterface;
use WellCommerce\CommonBundle\Breadcrumb\BreadcrumbItem;
use WellCommerce\CoreBundle\Controller\Front\AbstractFrontController;
use WellCommerce\CoreBundle\Controller\Front\FrontControllerInterface;

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
    public function indexAction(CategoryInterface $category)
    {
        $this->addBreadCrumbItem(new BreadcrumbItem([
            'name' => $category->translate()->getName(),
        ]));

        $this->manager->getCategoryContext()->setCurrentCategory($category);

        return $this->displayTemplate('index', [
            'category' => $category,
        ]);
    }
}
