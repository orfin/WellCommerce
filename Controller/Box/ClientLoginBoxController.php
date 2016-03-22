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

namespace WellCommerce\Bundle\ClientBundle\Controller\Box;

use Symfony\Component\HttpFoundation\Response;
use WellCommerce\Bundle\CoreBundle\Controller\Box\AbstractBoxController;
use WellCommerce\Bundle\LayoutBundle\Collection\LayoutBoxSettingsCollection;
use WellCommerce\Component\Form\Elements\FormInterface;

/**
 * Class ClientLoginBoxController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ClientLoginBoxController extends AbstractBoxController
{
    public function indexAction(LayoutBoxSettingsCollection $boxSettings) : Response
    {
        $form = $this->createForm();

        return $this->displayTemplate('index', [
            'form'     => $form,
            'elements' => $form->getChildren(),
            'error'    => $this->get('security.authentication_utils')->getLastAuthenticationError()
        ]);
    }

    protected function createForm() : FormInterface
    {
        return $this->get('client_login.form_builder.front')->createForm([
            'name'         => 'login',
            'ajax_enabled' => false,
            'action'       => $this->getRouterHelper()->generateUrl('front.client.login_check')
        ], null);
    }
}
