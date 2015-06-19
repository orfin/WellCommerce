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
 * Class ProductShowcaseBoxController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductShowcaseBoxController extends AbstractBoxController implements BoxControllerInterface
{
    /**
     * {@inheritdoc}
     */
    public function indexAction()
    {
        /**
         * @var $manager \WellCommerce\Bundle\ProductBundle\Manager\Front\ProductStatusManager
         */
        $manager           = $this->getManager();
        $provider          = $manager->getProvider('product');
        $collectionBuilder = $provider->getCollectionBuilder();
        $requestHelper     = $manager->getRequestHelper();

        $dataset = $collectionBuilder->getDataSet([
            'limit'      => $requestHelper->getQueryAttribute('limit', 1),
            'order_by'   => $requestHelper->getQueryAttribute('order_by', 'name'),
            'order_dir'  => $requestHelper->getQueryAttribute('order_dir', 'asc'),
            'conditions' => $manager->getStatusConditions($this->getBoxParam('status', null)),
        ]);

        return $this->render('WellCommerceProductBundle:Box/ProductShowcase:index.html.twig', [
            'dataset' => $dataset
        ]);
    }
}
