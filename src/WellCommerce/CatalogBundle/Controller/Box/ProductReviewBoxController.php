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
 * Class ProductReviewBoxController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductReviewBoxController extends AbstractBoxController implements BoxControllerInterface
{
    /**
     * @var \WellCommerce\CatalogBundle\Manager\Front\ProductReviewManager
     */
    protected $manager;
    
    /**
     * {@inheritdoc}
     */
    public function indexAction()
    {
        $product  = $this->manager->getProductContext()->getCurrentProduct();
        $resource = $this->manager->initResource();
        $resource->setProduct($product);

        $currentRoute = $product->translate()->getRoute()->getId();
        $form         = $this->manager->getForm($resource);

        if ($form->handleRequest()->isSubmitted()) {
            if ($form->isValid()) {
                $this->manager->createResource($resource);

                $this->manager->getFlashHelper()->addSuccess('product_review.flash.success');

                return $this->getRouterHelper()->redirectTo('dynamic_' . $currentRoute);
            }

            $this->manager->getFlashHelper()->addError('product_review.flash.error');
        }

        return $this->displayTemplate('index', [
            'form'    => $form,
            'reviews' => $product->getReviews()
        ]);
    }
}
