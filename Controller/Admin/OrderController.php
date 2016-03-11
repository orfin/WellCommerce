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

namespace WellCommerce\Bundle\OrderBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use WellCommerce\Bundle\CoreBundle\Controller\Admin\AbstractAdminController;
use WellCommerce\Bundle\OrderBundle\Context\Front\OrderContextInterface;
use WellCommerce\Bundle\OrderBundle\Entity\OrderInterface;

/**
 * Class OrderController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class OrderController extends AbstractAdminController
{
    public function editAction(Request $request) : Response
    {
        $resource = $this->manager->findResource($request);
        if (!$resource instanceof OrderInterface) {
            return $this->redirectToAction('index');
        }

        $this->getOrderContext()->setCurrentOrder($resource);

        $form = $this->manager->getForm($resource, [
            'class' => 'editOrder'
        ]);

        if ($form->handleRequest()->isSubmitted()) {
            if ($form->isValid()) {
                $this->manager->updateResource($resource);
            }

            return $this->createFormDefaultJsonResponse($form);
        }

        return $this->displayTemplate('edit', [
            'form'     => $form,
            'resource' => $resource
        ]);
    }

    protected function getOrderContext() : OrderContextInterface
    {
        return $this->get('order.context.admin');
    }
}
