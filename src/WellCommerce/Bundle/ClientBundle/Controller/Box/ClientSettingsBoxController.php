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

use WellCommerce\Bundle\CoreBundle\Controller\Box\AbstractBoxController;

/**
 * Class ClientSettingsBoxController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ClientSettingsBoxController extends AbstractBoxController
{
    public function indexAction()
    {
        $client             = $this->manager->getClient();
        $contactDetailsForm = $this->manager->getForm($client);

        if ($contactDetailsForm->handleRequest()->isSubmitted()) {
            if ($contactDetailsForm->isValid()) {
                $this->manager->updateResource($client);
            }

            $this->manager->getFlashHelper()->addSuccess('client.flash.contact_details.success');

            return $this->redirectToRoute('front.client_settings.index');
        }

        return $this->displayTemplate('index', [
            'contactDetailsForm' => $contactDetailsForm,
        ]);
    }
}
