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

use Symfony\Component\HttpFoundation\Response;
use WellCommerce\Bundle\CategoryBundle\Entity\CategoryInterface;
use WellCommerce\Bundle\CategoryBundle\Repository\CategoryRepositoryInterface;
use WellCommerce\Bundle\CoreBundle\Controller\Front\AbstractFrontController;
use WellCommerce\Component\Breadcrumb\Model\Breadcrumb;

/**
 * Class CategoryController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class CategoryController extends AbstractFrontController
{
    public function indexAction(CategoryInterface $category) : Response
    {
        $this->addBreadcrumbs($category);
        $this->getCategoryStorage()->setCurrentCategory($category);

        return $this->displayTemplate('index', [
            'category' => $category,
            'metadata' => $category->translate()->getMeta()
        ]);
    }

    private function addBreadcrumbs(CategoryInterface $category)
    {
        $paths = $this->getRepository()->getCategoryPath($category);

        /** @var CategoryInterface $path */
        foreach ($paths as $path) {
            $this->getBreadcrumbProvider()->add(new Breadcrumb([
                'label' => $path->translate()->getName(),
                'url'   => $this->getRouterHelper()->generateUrl($path->translate()->getRoute()->getId())
            ]));
        }
    }

    private function getRepository() : CategoryRepositoryInterface
    {
        return $this->getManager()->getRepository();
    }
}
