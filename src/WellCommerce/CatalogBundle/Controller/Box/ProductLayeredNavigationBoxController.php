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

namespace WellCommerce\CatalogBundle\Controller\Box;

use WellCommerce\CoreBundle\Controller\Box\AbstractBoxController;
use WellCommerce\CoreBundle\Controller\Box\BoxControllerInterface;

/**
 * Class ProductLayeredNavigationBoxController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductLayeredNavigationBoxController extends AbstractBoxController implements BoxControllerInterface
{
    /**
     * {@inheritdoc}
     */
    public function indexAction()
    {
        $producers = $this->get('producer.dataset.front')->getResult('array', [
            'order_by'  => 'name',
            'order_dir' => 'asc',
        ]);

        return $this->displayTemplate('index', [
            'producers' => $producers
        ]);
    }
}
