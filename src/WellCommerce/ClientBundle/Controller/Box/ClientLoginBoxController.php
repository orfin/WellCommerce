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

namespace WellCommerce\ClientBundle\Controller\Box;

use WellCommerce\CoreBundle\Controller\Box\AbstractBoxController;

/**
 * Class ClientLoginBoxController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ClientLoginBoxController extends AbstractBoxController
{
    public function indexAction()
    {
        $form = $this->createForm();

        return $this->displayTemplate('index', [
            'form'     => $form,
            'elements' => $form->getChildren(),
            'error'    => $this->get('security.authentication_utils')->getLastAuthenticationError()
        ]);
    }

    /**
     * @return \WellCommerce\Component\Form\Elements\FormInterface
     */
    protected function createForm()
    {
        return $this->get('client_login.form_builder.front')->createForm([
            'name'         => 'login',
            'ajax_enabled' => false,
            'action'       => $this->getRouterHelper()->generateUrl('front.client.login_check')
        ], null);
    }
}
