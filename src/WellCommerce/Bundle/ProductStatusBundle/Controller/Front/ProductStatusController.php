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

namespace WellCommerce\Bundle\AppBundle\Controller\Front;

use WellCommerce\Bundle\AppBundle\Entity\ProductStatusInterface;
use WellCommerce\Bundle\AppBundle\Service\Breadcrumb\BreadcrumbItem;
use WellCommerce\Bundle\CoreBundle\Controller\Front\AbstractFrontController;

/**
 * Class ProductStatusController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductStatusController extends AbstractFrontController
{
    /**
     * {@inheritdoc}
     */
    public function indexAction(ProductStatusInterface $productStatus)
    {
        $this->addBreadCrumbItem(new BreadcrumbItem([
            'name' => $productStatus->translate()->getName(),
        ]));

        $this->manager->getProductStatusContext()->setCurrentProductStatus($productStatus);

        return $this->displayTemplate('index', [
            'status' => $productStatus
        ]);
    }
}
