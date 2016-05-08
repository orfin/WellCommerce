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

namespace WellCommerce\Bundle\ProductStatusBundle\Controller\Front;

use Symfony\Component\HttpFoundation\Response;
use WellCommerce\Bundle\CoreBundle\Controller\Front\AbstractFrontController;
use WellCommerce\Bundle\ProductStatusBundle\Entity\ProductStatusInterface;
use WellCommerce\Component\Breadcrumb\Model\Breadcrumb;

/**
 * Class ProductStatusController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductStatusController extends AbstractFrontController
{
    public function indexAction(ProductStatusInterface $status) : Response
    {
        $this->getBreadcrumbProvider()->add(new Breadcrumb([
            'label' => $status->translate()->getName(),
        ]));

        $this->getProductStatusStorage()->setCurrentProductStatus($status);

        return $this->displayTemplate('index', [
            'status' => $status
        ]);
    }
}
