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

namespace WellCommerce\Bundle\ProducerBundle\Controller\Front;

use WellCommerce\Bundle\CoreBundle\Controller\Front\AbstractFrontController;
use WellCommerce\Bundle\CoreBundle\Service\Breadcrumb\BreadcrumbItem;
use WellCommerce\Bundle\ProducerBundle\Entity\ProducerInterface;

/**
 * Class ProducerController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProducerController extends AbstractFrontController
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
