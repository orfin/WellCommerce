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

use WellCommerce\Bundle\ClientBundle\Entity\ClientInterface;
use WellCommerce\Bundle\ClientBundle\Exception\ResetPasswordException;
use WellCommerce\Bundle\CoreBundle\Controller\Box\AbstractBoxController;

/**
 * Class ClientForgotPasswordBoxController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ClientForgotPasswordBoxController extends AbstractBoxController
{
    public function resetAction()
    {
        $form = $this->getForm(null);
        
        if ($form->handleRequest()->isSubmitted()) {
            $data = $form->getValue();
            
            try {
                $this->manager->resetPassword($data['_username']);
                $this->getFlashHelper()->addSuccess('client.flash.reset_password.success');
            } catch (ResetPasswordException $e) {
                $this->getFlashHelper()->addError($e->getMessage());
            }
            
            return $this->getRouterHelper()->redirectTo('front.client_password.reset');
        }
        
        return $this->displayTemplate('reset', [
            'form' => $form,
        ]);
    }
    
    public function changeAction()
    {
        $hash   = $this->getRequestHelper()->getAttributesBagParam('hash');
        $client = $this->getManager()->getRepository()->findOneBy(['clientDetails.resetPasswordHash' => $hash]);
        
        if (!$client instanceof ClientInterface) {
            return $this->getRouterHelper()->redirectToAction('reset');
        }
        
        $client->getClientDetails()->resetPassword();
        $form = $this->createChangePasswordForm($client);
        
        if ($form->handleRequest()->isSubmitted()) {
            if ($form->isValid()) {
                $this->getManager()->updateResource($client);
                $this->getFlashHelper()->addSuccess('client.flash.change_password.success');
                
                return $this->getRouterHelper()->redirectTo('front.client.login');
            }
            
            $this->getFlashHelper()->addError('client.flash.change_password.error');
        }
        
        return $this->displayTemplate('change', [
            'form' => $form,
        ]);
    }
    
    /**
     * Creates a change password form for client
     *
     * @param ClientInterface $client
     *
     * @return \WellCommerce\Component\Form\Elements\FormInterface
     */
    protected function createChangePasswordForm(ClientInterface $client)
    {
        return $this->get('client_forgot_password_change.form_builder.front')->createForm([
            'name'              => 'change_password',
            'validation_groups' => ['client_password_change']
        ], $client);
    }
}
