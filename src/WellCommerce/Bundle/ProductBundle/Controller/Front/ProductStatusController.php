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
 *
 * @Sensio\Bundle\FrameworkExtraBundle\Configuration\Template()
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

            $this->get('breadcrumb.builder')->add(new BreadcrumbItem([
                'name' => $status->translate()->getName(),
                'link' => $this->get('router')->generate((string)$status->translate()->getRoute()->getId())
            ]));

            $this->get('breadcrumb.builder')->add(new BreadcrumbItem([
                'name'  => '/',
                'link'  => '',
                'class' => 'divider'
            ]));

            $this->getManager()->getProvider('product_status')->setCurrentResource($status);
        }

        return [
            'status'     => $status,
            'breadcrumb' => $this->get('breadcrumb.builder')->all()
        ];
    }
}
