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

namespace WellCommerce\Bundle\ProducerBundle\Controller\Box;

use WellCommerce\Bundle\CoreBundle\Controller\Box\AbstractBoxController;

/**
 * Class ProducerMenuBoxController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProducerMenuBoxController extends AbstractBoxController
{
    /**
     * {@inheritdoc}
     */
    public function indexAction()
    {
        $producers = $this->get('producer.dataset.front')->getResult('array');

        return $this->displayTemplate('index', [
            'producers'      => $producers,
            'activeProducer' => $this->manager->getProducerContext()->getCurrentProducerIdentifier()
        ]);
    }
}
