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

namespace WellCommerce\Bundle\ProductBundle\Controller\Box;

use Symfony\Component\HttpFoundation\Response;
use WellCommerce\Bundle\CoreBundle\Controller\Box\AbstractBoxController;
use WellCommerce\Bundle\LayoutBundle\Collection\LayoutBoxSettingsCollection;

/**
 * Class ProductInfoBoxController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductInfoBoxController extends AbstractBoxController
{
    public function indexAction(LayoutBoxSettingsCollection $boxSettings) : Response
    {
        $product      = $this->getProductStorage()->getCurrentProduct();
        $templateData = $this->get('product.helper')->getProductDefaultTemplateData($product);
        
        return $this->displayTemplate('index', $templateData);
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
