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
use WellCommerce\Bundle\CartBundle\Exception\ChangeCartItemQuantityException;
use WellCommerce\Bundle\CartBundle\Exception\DeleteCartItemException;
use WellCommerce\Bundle\CategoryBundle\Entity\Category;
use WellCommerce\Bundle\CoreBundle\Controller\Front\AbstractFrontController;
use WellCommerce\Bundle\CoreBundle\Controller\Front\FrontControllerInterface;
use WellCommerce\Bundle\DataSetBundle\Conditions\Condition\Eq;
use WellCommerce\Bundle\DataSetBundle\Conditions\ConditionsCollection;
use WellCommerce\Bundle\WebBundle\Breadcrumb\BreadcrumbItem;

/**
 * Class CartController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CartController extends AbstractFrontController implements FrontControllerInterface
{
    /**
     * {@inheritdoc}
     */
    public function indexAction(Request $request)
    {
        $this->addBreadCrumbItem(new BreadcrumbItem([
            'name' => $this->trans('cart.heading.index')
        ]));

        $manager  = $this->getManager();
        $resource = $this->getManager()->getCartProvider()->getCurrentCart();
        $form     = $this->get('cart.form_builder')->createForm([
            'name' => 'cart'
        ], $resource);

        if ($form->handleRequest()->isSubmitted()) {
            if ($form->isValid()) {
                $manager->updateResource($resource, $request);

                return $manager->getRedirectHelper()->redirectTo('front.cart.index');
            }

            if (count($form->getError())) {
                $manager->getFlashHelper()->addError('client.form.error.registration');
            }
        }

        return $this->render('WellCommerceCartBundle:Front/Cart:index.html.twig', [
            'form'     => $form,
            'elements' => $form->getChildren(),
        ]);
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
        $quantity        = (int)$manager->getRequestHelper()->getRequestAttribute('qty', 1);
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

    public function editAction()
    {
        $manager = $this->getManager();
        $message = null;
        $success = null;

        try {
            $manager->changeItemQuantity();
            $success = true;
        } catch (ChangeCartItemQuantityException $e) {
            $success = false;
            $message = $e->getMessage();
        }

        return $this->jsonResponse([
            'success' => $success,
            'message' => $message,
        ]);
    }

    public function deleteAction()
    {
        $manager = $this->getManager();
        $message = null;
        $success = null;

        try {
            $manager->deleteItem();
            $success = true;
        } catch (DeleteCartItemException $e) {
            $success = false;
            $message = $e->getMessage();
        }

        return $this->jsonResponse([
            'success' => $success,
            'message' => $message,
        ]);
    }
}
