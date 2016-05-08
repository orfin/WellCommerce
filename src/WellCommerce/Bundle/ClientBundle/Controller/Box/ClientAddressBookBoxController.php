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
 * Class ClientAddressBookBoxController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ClientAddressBookBoxController extends AbstractBoxController
{
    public function indexAction(LayoutBoxSettingsCollection $boxSettings) : Response
    {
        $client          = $this->getAuthenticatedClient();
        $addressBookForm = $this->getForm($client, [
            'name'              => 'client_address_book',
            'validation_groups' => ['client_address_book']
        ]);

        if ($addressBookForm->handleRequest()->isSubmitted()) {
            if ($addressBookForm->isValid()) {
                $this->getManager()->updateResource($client);

                $this->getFlashHelper()->addSuccess('client.flash.address_book.success');

                return $this->redirectToRoute('front.client_address_book.index');
            }

            $this->getFlashHelper()->addError('client.flash.contact_details.error');
        }

        return $this->displayTemplate('index', [
            'form' => $addressBookForm,
        ]);
    }
}
