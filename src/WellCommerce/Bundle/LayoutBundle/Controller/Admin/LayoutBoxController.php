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

namespace WellCommerce\Bundle\LayoutBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PropertyAccess\PropertyAccess;
use WellCommerce\Bundle\CoreBundle\Controller\Admin\AbstractAdminController;
use WellCommerce\Bundle\LayoutBundle\Entity\LayoutBoxInterface;

/**
 * Class LayoutBoxController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LayoutBoxController extends AbstractAdminController
{
    public function addAction(Request $request) : Response
    {
        /** @var LayoutBoxInterface $resource */
        $resource = $this->getManager()->initResource();
        $form     = $this->getForm($resource);

        if ($form->handleRequest()->isSubmitted()) {
            if ($form->isValid()) {
                $settings = $this->getBoxSettingsFromRequest($request);
                $resource->setSettings($settings);
                $this->getManager()->createResource($resource);
            }

            return $this->createFormDefaultJsonResponse($form);
        }

        return $this->displayTemplate('add', [
            'form' => $form
        ]);
    }

    protected function getBoxSettingsFromRequest(Request $request) : array
    {
        $settings   = [];
        $accessor   = PropertyAccess::createPropertyAccessor();
        $parameters = $request->request->all();
        $boxType    = $accessor->getValue($parameters, '[required_data][boxType]');
        if ($accessor->isReadable($parameters, '[' . $boxType . ']')) {
            $settings = $accessor->getValue($parameters, '[' . $boxType . ']');
        }

        return !is_array($settings) ? [] : $settings;
    }
}
