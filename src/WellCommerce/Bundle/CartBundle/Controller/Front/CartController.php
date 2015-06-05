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

namespace WellCommerce\Bundle\CartBundle\Controller\Front;

use Symfony\Component\HttpFoundation\Request;
use WellCommerce\Bundle\CategoryBundle\Entity\Category;
use WellCommerce\Bundle\CoreBundle\Controller\Front\AbstractFrontController;
use WellCommerce\Bundle\CoreBundle\Controller\Front\FrontControllerInterface;
use WellCommerce\Bundle\DataSetBundle\Conditions\Condition\Eq;
use WellCommerce\Bundle\DataSetBundle\Conditions\ConditionsCollection;

/**
 * Class CartController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 *
 * @Sensio\Bundle\FrameworkExtraBundle\Configuration\Template()
 */
class CartController extends AbstractFrontController implements FrontControllerInterface
{
    /**
     * {@inheritdoc}
     */
    public function indexAction(Request $request)
    {
        $manager  = $this->getManager();
        $resource = $manager->initResource();
        $form     = $this->get('client_register.form_builder.front')->createForm([
            'name' => 'register'
        ], $resource);

        if ($form->handleRequest()->isSubmitted()) {
            if ($form->isValid()) {
                $manager->createResource($resource, $request);

                $manager->getFlashHelper()->addSuccess('client.flash.registration.success');

                return $manager->getRedirectHelper()->redirectTo('front.client.login');
            }

            if (count($form->getError())) {
                $manager->getFlashHelper()->addError('client.form.error.registration');
            }
        }

        return [
            'form'     => $form,
            'elements' => $form->getChildren(),
        ];
    }

    /**
     * @return \WellCommerce\Bundle\CartBundle\Manager\Front\CartManager
     */
    protected function getManager()
    {
        return parent::getManager();
    }

    public function addAction()
    {
        $manager         = $this->getManager();
        $product         = $manager->findProduct();
        $attribute       = $manager->findProductAttribute($product);
        $quantity        = $manager->getRequestHelper()->getRequestAttribute('qty', 1);
        $category        = $product->getCategories()->first();
        $recommendations = $this->getRecommendations($category);

        $manager->addItem($product, $attribute, $quantity);

        $basketModalContent = $this->renderView('WellCommerceCartBundle:Front/Cart:add.html.twig', [
            'product'         => $product,
            'recommendations' => $recommendations
        ]);

        $cartPreviewContent = $this->renderView('WellCommerceCartBundle:Front/Common:preview.html.twig');

        return $this->jsonResponse([
            'basketModalContent' => $basketModalContent,
            'cartPreviewContent' => $cartPreviewContent
        ]);
    }

    protected function getRecommendations(Category $category)
    {
        $provider          = $this->getManager()->getProductProvider();
        $collectionBuilder = $provider->getCollectionBuilder();
        $conditions        = new ConditionsCollection();
        $conditions->add(new Eq('category', $category->getId()));

        $dataset = $collectionBuilder->getDataSet([
            'limit'      => 3,
            'order_by'   => 'name',
            'order_dir'  => 'asc',
            'conditions' => $conditions
        ]);

        return $dataset;
    }

    public function deleteAction()
    {
        $manager = $this->getManager();
        $manager->deleteItem();

        return $this->redirectToAction('index');
    }
}
