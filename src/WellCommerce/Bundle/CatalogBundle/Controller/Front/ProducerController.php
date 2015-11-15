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

namespace WellCommerce\Bundle\CatalogBundle\Controller\Front;

use WellCommerce\Bundle\CoreBundle\Controller\Front\AbstractFrontController;
use WellCommerce\Bundle\CoreBundle\Controller\Front\FrontControllerInterface;
use WellCommerce\Bundle\CatalogBundle\Entity\ProducerInterface;
use WellCommerce\Bundle\WebBundle\Breadcrumb\BreadcrumbItem;

/**
 * Class ProducerController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProducerController extends AbstractFrontController implements FrontControllerInterface
{
    public function indexAction(ProducerInterface $producer)
    {
        $this->addBreadCrumbItem(new BreadcrumbItem([
            'name' => $producer->translate()->getName(),
        ]));

        $this->manager->getProducerContext()->setCurrentProducer($producer);

        return $this->displayTemplate('index', [
            'producer' => $producer,
        ]);
    }
}
