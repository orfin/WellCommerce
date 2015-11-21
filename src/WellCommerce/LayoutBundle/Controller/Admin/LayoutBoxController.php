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

namespace WellCommerce\LayoutBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PropertyAccess\PropertyAccess;
use WellCommerce\CoreBundle\Controller\Admin\AbstractAdminController;

/**
 * Class LayoutBoxController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LayoutBoxController extends AbstractAdminController
{
    public function addAction(Request $request)
    {
        $resource = $this->manager->initResource();
        $form     = $this->manager->getForm($resource);

        if ($form->handleRequest()->isSubmitted()) {
            if ($form->isValid()) {
                $settings = $this->getBoxSettingsFromRequest($request);
                $resource->setSettings($settings);
                $this->manager->createResource($resource);
            }

            return $this->createFormDefaultJsonResponse($form);
        }

        return $this->displayTemplate('add', [
            'form' => $form
        ]);
    }

    /**
     * Returns box settings from request
     *
     * @param Request $request
     *
     * @return mixed
     */
    protected function getBoxSettingsFromRequest(Request $request)
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
