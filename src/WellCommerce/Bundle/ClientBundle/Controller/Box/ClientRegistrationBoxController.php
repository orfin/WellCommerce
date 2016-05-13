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

/**
 * Class ClientRegistrationBoxController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ClientRegistrationBoxController extends AbstractBoxController
{
    public function indexAction(LayoutBoxSettingsCollection $boxSettings) : Response
    {
        $manager  = $this->getManager();
        $resource = $manager->initResource();
        
        $form = $this->getForm($resource, [
            'name'              => 'register',
            'validation_groups' => ['client_registration']
        ]);
        
        if ($form->handleRequest()->isSubmitted()) {
            if ($form->isValid()) {
                $manager->createResource($resource);
                
                $this->getFlashHelper()->addSuccess('client.flash.registration.success');
                
                return $this->getRouterHelper()->redirectTo('front.client.login');
            }
            
            $this->getFlashHelper()->addError('client.flash.registration.error');
        }
        
        return $this->displayTemplate('index', [
            'form' => $form,
        ]);
    }
}
