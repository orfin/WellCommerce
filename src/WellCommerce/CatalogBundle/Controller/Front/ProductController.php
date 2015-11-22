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

use WellCommerce\CatalogBundle\Entity\ProductInterface;
use WellCommerce\CoreBundle\Service\Breadcrumb\BreadcrumbItem;
use WellCommerce\CoreBundle\Controller\Front\AbstractFrontController;
use WellCommerce\CoreBundle\Controller\Front\FrontControllerInterface;

/**
 * Class ProductController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductController extends AbstractFrontController implements FrontControllerInterface
{
    public function indexAction(ProductInterface $product)
    {
        $this->addBreadCrumbItem(new BreadcrumbItem([
            'name' => $product->translate()->getName(),
        ]));

        $this->manager->getProductContext()->setCurrentProduct($product);

        return $this->displayTemplate('index', [
            'product' => $product
        ]);
    }

    public function viewAction(ProductInterface $product)
    {
        $this->manager->getProductContext()->setCurrentProduct($product);

        $templateData       = $this->get('product.helper')->getProductDefaultTemplateData($product);
        $basketModalContent = $this->renderView('WellCommerceCatalogBundle:Front/Product:view.html.twig', $templateData);

        return $this->jsonResponse([
            'basketModalContent' => $basketModalContent,
            'attributes'         => $templateData['attributes']
        ]);
    }
}
