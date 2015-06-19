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

namespace WellCommerce\Bundle\ProductBundle\Controller\Front;

use Symfony\Component\HttpFoundation\Request;
use WellCommerce\Bundle\CoreBundle\Controller\Front\AbstractFrontController;
use WellCommerce\Bundle\CoreBundle\Controller\Front\FrontControllerInterface;
use WellCommerce\Bundle\ProductBundle\Entity\ProductStatus;
use WellCommerce\Bundle\WebBundle\Breadcrumb\BreadcrumbItem;

/**
 * Class ProductStatusController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductStatusController extends AbstractFrontController implements FrontControllerInterface
{
    /**
     * {@inheritdoc}
     */
    public function indexAction(Request $request)
    {
        $status = $this->findOr404($request);

        if ($status instanceof ProductStatus) {

            $this->addBreadCrumbItem(new BreadcrumbItem([
                'name' => $status->translate()->getName(),
            ]));

            $this->getManager()->getProductStatusProvider()->setCurrentProductStatus($status);
        }

        return $this->render('WellCommerceProductBundle:Front/ProductStatus:index.html.twig', [
            'status' => $status
        ]);
    }
}
