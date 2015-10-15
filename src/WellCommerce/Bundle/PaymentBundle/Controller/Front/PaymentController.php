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

namespace WellCommerce\Bundle\PaymentBundle\Controller\Front;

use Doctrine\Common\Util\Debug;
use WellCommerce\Bundle\CoreBundle\Controller\Front\AbstractFrontController;
use WellCommerce\Bundle\CoreBundle\Controller\Front\FrontControllerInterface;

/**
 * Class PaymentController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class PaymentController extends AbstractFrontController implements FrontControllerInterface
{
    /**
     * @var \WellCommerce\Bundle\PaymentBundle\Manager\Front\PaymentManagerInterface
     */
    protected $manager;

    public function indexAction()
    {
        try {
            $order = $this->manager->findOrder();
            $this->manager->registerPayment($order);
        } catch (\Exception $e) {
            return $this->redirectToRoute('front.home_page.index');
        }

        $processor = $order->getPaymentMethod()->getProcessor();

        return $this->displayTemplate($processor, [
            'order' => $order
        ]);
    }
}
