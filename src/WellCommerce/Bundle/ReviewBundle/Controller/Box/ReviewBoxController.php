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

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Yaml\Yaml;
use WellCommerce\Bundle\CoreBundle\Controller\Box\AbstractBoxController;
use WellCommerce\Bundle\LayoutBundle\Collection\LayoutBoxSettingsCollection;
use WellCommerce\Bundle\ReviewBundle\Entity\ReviewInterface;

/**
 * Class ReviewBoxController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */

class ReviewBoxController extends AbstractBoxController
{
    public function indexAction(LayoutBoxSettingsCollection $boxSettings) : Response
    {
        $product = $this->getProductStorage()->getCurrentProduct();

        /** @var ReviewInterface $resource */
        $resource = $this->getManager()->initResource();
        $resource->setProduct($product);

        $currentRoute = $product->translate()->getRoute()->getId();
        $form         = $this->getForm($resource);


        if ($form->handleRequest()->isSubmitted()) {
            if ($form->isValid()) {
                $this->getManager()->createResource($resource);

                $this->getFlashHelper()->addSuccess('review.flash.success');

                return $this->getRouterHelper()->redirectTo('dynamic_' . $currentRoute);
            }

            $this->getFlashHelper()->addError('review.flash.error');
        }

        return $this->displayTemplate('index', [
            'form'    => $form,
            'reviews' => $product->getReviews()
        ]);


    }

    public function reportAction(int $id) {
        $review = $this->getManager()->getRepository()->findOneBy([
            'id' => $id,
            'enabled' => 1
        ]);
        if(null !== $review) {
            //$review->setEnabled(false);
            //$this->getManager()->updateResource($review);
            $currentRoute = $review->getProduct()->translate()->getRoute()->getId();

            $this->getMailerHelper()->sendEmail([
                'recipient' => 'rafal@wellcommerce.org',
                'subject' => 'Raport opinii.',
                'template' => 'WellCommerceAppBundle:Email:report_review.html.twig',
                'parameters' => [
                    'review' => $review,
                ],
                'configuration' => $this->getShopStorage()->getCurrentShop()->getMailerConfiguration(),
            ]);
            $this->getFlashHelper()->addSuccess('report.flash.success');
            return $this->getRouterHelper()->redirectTo('dynamic_' . $currentRoute);
        } else {
            return $this->getRouterHelper()->redirectTo('front.home_page.index');
        }
    }
}
