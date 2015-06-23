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
use WellCommerce\Bundle\LayoutBundle\Collection\LayoutBoxSettingsCollection;

/**
 * Class ProductShowcaseBoxController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductStatusBoxController extends AbstractBoxController implements BoxControllerInterface
{
    /**
     * {@inheritdoc}
     */
    public function indexAction(LayoutBoxSettingsCollection $boxSettings)
    {
        /**
         * @var $manager \WellCommerce\Bundle\ProductBundle\Manager\Front\ProductStatusManager
         */
        $manager           = $this->getManager();
        $productProvider   = $manager->getProvider('product');
        $collectionBuilder = $productProvider->getCollectionBuilder();
        $requestHelper     = $manager->getRequestHelper();

        $dataset = $collectionBuilder->getDataSet([
            'limit'         => $requestHelper->getQueryAttribute('limit', $boxSettings->getParam('per_page', 12)),
            'order_by'      => $requestHelper->getQueryAttribute('order_by', 'price'),
            'order_dir'     => $requestHelper->getQueryAttribute('order_dir', 'asc'),
            'conditions'    => $manager->getStatusConditions($boxSettings->getParam('status')),
            'cache_enabled' => true
        ]);

        return $this->render('WellCommerceProductBundle:Box/ProductStatus:index.html.twig', [
            'dataset' => $dataset
        ]);
    }
}
