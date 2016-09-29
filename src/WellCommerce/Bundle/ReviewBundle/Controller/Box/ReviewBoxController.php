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

use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use WellCommerce\Bundle\CoreBundle\Controller\Box\AbstractBoxController;
use WellCommerce\Bundle\LayoutBundle\Collection\LayoutBoxSettingsCollection;
use WellCommerce\Bundle\ReviewBundle\Entity\ReviewInterface;
use WellCommerce\Bundle\ReviewBundle\Repository\ReviewRepositoryInterface;


/**
 * Class ReviewBoxController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ReviewBoxController extends AbstractBoxController
{
    const RECOMMENDATION_COOKIE_EXPIRE = 86400 * 30 * 12 * 4;
    
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
                if (false === $this->get('security.authorization_checker')->isGranted('ROLE_CLIENT')
                    && false === $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')
                ) {
                    $resource->setEnabled(0);
                }
                $this->getManager()->createResource($resource);
                
                $this->getFlashHelper()->addSuccess('review.flash.success');
                
                return $this->getRouterHelper()->redirectTo('dynamic_' . $currentRoute);
            }
            
            $this->getFlashHelper()->addError('review.flash.error');
        }
        
        return $this->displayTemplate('index', [
            'form'    => $form,
            'reviews' => $this->getRepository()->getProductReviews($product)
        ]);
    }
    
    public function reportAction(int $id)
    {
        $review = $this->getManager()->getRepository()->findOneBy([
            'id'      => $id,
            'enabled' => 1
        ]);
        
        if ($review instanceof ReviewInterface) {
            $currentRoute        = $review->getProduct()->translate()->getRoute()->getId();
            $mailerConfiguration = $this->getShopStorage()->getCurrentShop()->getMailerConfiguration();
            
            $this->getMailerHelper()->sendEmail([
                'recipient'     => $mailerConfiguration->getFrom(),
                'subject'       => $this->trans('review.email.heading.report'),
                'template'      => 'WellCommerceAppBundle:Email:report_review.html.twig',
                'parameters'    => [
                    'review' => $review,
                ],
                'configuration' => $mailerConfiguration,
            ]);
            
            $this->getFlashHelper()->addSuccess('report.flash.success');
            
            return $this->getRouterHelper()->redirectTo('dynamic_' . $currentRoute);
        }
    }
    
    public function recommendationAction(int $id, bool $like = true) : JsonResponse
    {
        
        try {
            $cookie      = $this->getRequestHelper()->getCurrentRequest()->cookies->get('likedReviews');
            $reviewLiked = unserialize($cookie);
            
            if (!is_array($reviewLiked)) {
                $reviewLiked = [];
            }
            
            if (in_array($id, $reviewLiked)) {
                throw new Exception($this->trans('review.label.recommendation_exists'));
            }
            
            $review = $this->getManager()->getRepository()->findOneBy([
                'id'      => $id,
                'enabled' => 1
            ]);
            
            if (null === $review) {
                throw new Exception($this->trans('review.label.review_not_exists'));
            }
            
            
            $reviewRecommendationFactory = $this->get('review_recommendation.manager');
            
            $reviewRecommendation = $reviewRecommendationFactory->initResource();
            if ($like == true) {
                $reviewRecommendation->setLiked(true);
            } else {
                $reviewRecommendation->setUnliked(true);
            }
            $reviewRecommendation->setReview($review);
            $this->getManager()->updateResource($reviewRecommendation);
            $this->getManager()->updateResource($review);
            $review->addRecommendation($reviewRecommendation);
            
            $reviewLikes = $reviewRecommendationFactory->getRepository()->findBy([
                'review' => $review,
                'liked'  => true
            ]);
            
            $reviewUnlikes = $reviewRecommendationFactory->getRepository()->findBy([
                'review'  => $review,
                'unliked' => true
            ]);
            
            $result = [
                'success' => true,
                'likes'   => count($reviewLikes),
                'unlikes' => count($reviewUnlikes)
            ];
        } catch (Exception $e) {
            $result = [
                'error'   => true,
                'message' => $e->getMessage(),
            ];
        }
        
        array_push($reviewLiked, $id);
        
        $response = $this->jsonResponse($result);
        $response->headers->setCookie(new Cookie('likedReviews', serialize($reviewLiked), time() + static::RECOMMENDATION_COOKIE_EXPIRE));
        
        return $response;
    }
    
    private function getRepository() : ReviewRepositoryInterface
    {
        return $this->getManager()->getRepository();
    }
}
