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
     * @var \WellCommerce\Bundle\CartBundle\Manager\Front\CartManager
     */
    protected $manager;

    /**
     * {@inheritdoc}
     */
    public function indexAction(Request $request)
    {
        $this->addBreadCrumbItem(new BreadcrumbItem([
            'name' => $this->trans('cart.heading.index')
        ]));

        $resource = $this->manager->getCartProvider()->getCurrentCart();
        $form     = $this->get('cart.form_builder')->createForm([
            'name' => 'cart'
        ], $resource);

        if ($form->handleRequest()->isSubmitted()) {
            if ($form->isValid()) {
                $this->manager->updateResource($resource, $request);

                return $this->manager->getRedirectHelper()->redirectTo('front.cart.index');
            }

            if (count($form->getError())) {
                $this->manager->getFlashHelper()->addError('client.form.error.registration');
            }
        }

        return $this->displayTemplate('index', [
            'form'     => $form,
            'elements' => $form->getChildren(),
        ]);
    }

    public function addAction()
    {
        $product         = $this->manager->findProduct();
        $attribute       = $this->manager->findProductAttribute($product);
        $quantity        = (int)$this->manager->getRequestHelper()->getRequestAttribute('qty', 1);
        $category        = $product->getCategories()->first();
        $recommendations = $this->getRecommendations($category);

        $this->manager->addItem($product, $attribute, $quantity);

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
        $provider          = $this->manager->getProductProvider();
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

    public function editAction(Request $request)
    {
        $message = null;
        $id      = (int)$request->request->get('id');
        $qty     = (int)$request->request->get('qty');

        try {
            $this->manager->changeItemQuantity($id, $qty);
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

    public function deleteAction(Request $request)
    {
        $message = null;
        $id      = (int)$request->request->get('id');

        try {
            $this->manager->deleteItem($id);
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
