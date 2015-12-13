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

namespace WellCommerce\Bundle\ReviewBundle\Controller\Box;

use WellCommerce\Bundle\CoreBundle\Controller\Box\AbstractBoxController;

/**
 * Class ReviewBoxController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ReviewBoxController extends AbstractBoxController
{
    /**
     * @var \WellCommerce\Bundle\ReviewBundle\Manager\Front\ReviewManager
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

                $this->manager->getFlashHelper()->addSuccess('review.flash.success');

                return $this->getRouterHelper()->redirectTo('dynamic_' . $currentRoute);
            }

            $this->manager->getFlashHelper()->addError('review.flash.error');
        }

        return $this->displayTemplate('index', [
            'form'    => $form,
            'reviews' => $product->getReviews()
        ]);
    }
}
