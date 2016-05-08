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

use Symfony\Component\HttpFoundation\Response;
use WellCommerce\Bundle\CoreBundle\Controller\Front\AbstractFrontController;
use WellCommerce\Bundle\ProducerBundle\Entity\ProducerInterface;
use WellCommerce\Component\Breadcrumb\Model\Breadcrumb;

/**
 * Class ProducerController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProducerController extends AbstractFrontController
{
    public function indexAction(ProducerInterface $producer) : Response
    {
        $this->getBreadcrumbProvider()->add(new Breadcrumb([
            'label' => $producer->translate()->getName(),
        ]));

        $this->getProducerStorage()->setCurrentProducer($producer);

        return $this->displayTemplate('index', [
            'producer' => $producer,
        ]);
    }
}
