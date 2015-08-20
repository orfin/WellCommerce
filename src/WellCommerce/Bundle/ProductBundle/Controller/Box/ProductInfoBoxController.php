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

namespace WellCommerce\Bundle\ProductBundle\Controller\Box;

use WellCommerce\Bundle\CoreBundle\Controller\Box\AbstractBoxController;
use WellCommerce\Bundle\CoreBundle\Controller\Box\BoxControllerInterface;

/**
 * Class ProductInfoBoxController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductInfoBoxController extends AbstractBoxController implements BoxControllerInterface
{
    /**
     * {@inheritdoc}
     */
    public function indexAction()
    {
        $provider = $this->manager->getProductProvider();

        return $this->displayTemplate('index', [
            'product' => $provider->getCurrentProduct()
        ]);
    }
}
