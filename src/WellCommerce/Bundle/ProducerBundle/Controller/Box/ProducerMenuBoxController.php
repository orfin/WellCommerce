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

use Symfony\Component\HttpFoundation\Response;
use WellCommerce\Bundle\CoreBundle\Controller\Box\AbstractBoxController;
use WellCommerce\Bundle\LayoutBundle\Collection\LayoutBoxSettingsCollection;

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
    public function indexAction(LayoutBoxSettingsCollection $boxSettings) : Response
    {
        $producers = $this->get('producer.dataset.front')->getResult('array', [], ['pagination' => false]);

        return $this->displayTemplate('index', [
            'producers'      => $producers,
            'activeProducer' => $this->getProducerStorage()->getCurrentProducerIdentifier()
        ]);
    }
}
