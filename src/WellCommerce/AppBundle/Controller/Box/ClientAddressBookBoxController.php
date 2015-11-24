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

namespace WellCommerce\AppBundle\Controller\Box;

use WellCommerce\CoreBundle\Controller\Box\AbstractBoxController;

/**
 * Class ClientAddressBookBoxController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ClientAddressBookBoxController extends AbstractBoxController
{
    public function indexAction()
    {
        $client          = $this->manager->getClient();
        $addressBookForm = $this->manager->getForm($client, [
            'name'              => 'address_book',
            'validation_groups' => ['address']
        ]);

        if ($addressBookForm->handleRequest()->isSubmitted()) {
            if ($addressBookForm->isValid()) {
                $this->manager->updateResource($client);

                $this->manager->getFlashHelper()->addSuccess('client.flash.address_book.success');

                return $this->redirectToRoute('front.client_address_book.index');
            }

            $this->manager->getFlashHelper()->addError('client.flash.contact_details.error');
        }

        return $this->displayTemplate('index', [
            'form' => $addressBookForm,
        ]);
    }
}
