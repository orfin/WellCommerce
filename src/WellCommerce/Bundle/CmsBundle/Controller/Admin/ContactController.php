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

namespace WellCommerce\Bundle\CmsBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use WellCommerce\Bundle\CmsBundle\Entity\Contact;
use WellCommerce\Bundle\CoreBundle\Controller\Admin\AbstractAdminController;

/**
 * Class ContactController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 *
 * @Sensio\Bundle\FrameworkExtraBundle\Configuration\Template()
 */
class ContactController extends AbstractAdminController
{
    public function editAction(Request $request)
    {
        $resource = $this->findOr404($request);
        $form     = $this->getForm($resource);

        if ($form->isValidRequest()) {
            $this->manager->updateResource($resource, $request);

            if ($form->isAction('continue')) {
                return $this->redirectToAction('edit', [
                    'id' => $resource->getId()
                ]);
            }

            if ($form->isAction('next')) {
                return $this->redirectToAction('add');
            }

            return $this->redirectToAction('index');
        }

        return [
            'form' => $form
        ];
    }
}
