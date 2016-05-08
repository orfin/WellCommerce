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
 * Class ClientSettingsBoxController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ClientSettingsBoxController extends AbstractBoxController
{
    public function indexAction(LayoutBoxSettingsCollection $boxSettings) : Response
    {
        $client             = $this->getAuthenticatedClient();
        $contactDetailsForm = $this->getForm($client, [
            'name'              => 'contact_details',
            'validation_groups' => ['client_settings']
        ]);

        if ($contactDetailsForm->handleRequest()->isSubmitted()) {
            if ($contactDetailsForm->isValid()) {
                $this->getManager()->updateResource($client);

                $this->getFlashHelper()->addSuccess('client.flash.contact_details.success');

                return $this->redirectToRoute('front.client_settings.index');
            }

            $this->getFlashHelper()->addError('client.flash.contact_details.error');
        }

        return $this->displayTemplate('index', [
            'contactDetailsForm' => $contactDetailsForm,
        ]);
    }
}
