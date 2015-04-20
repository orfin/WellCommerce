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
use Symfony\Component\PropertyAccess\PropertyAccess;
use WellCommerce\Bundle\AdminBundle\Controller\AbstractAdminController;

/**
 * Class LayoutBoxController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 *
 * @Sensio\Bundle\FrameworkExtraBundle\Configuration\Template()
 */
class LayoutBoxController extends AbstractAdminController
{
    public function addAction(Request $request)
    {
        $resource = $this->getManager()->initResource();
        $form     = $this->getManager()->getForm($resource);

        if ($form->handleRequest()->isSubmitted()) {
            if ($form->isValid()) {
                $settings = $this->getBoxSettingsFromRequest($request);
                $resource->setSettings($settings);
                $this->getManager()->createResource($resource, $request);
            }

            return $this->createJsonDefaultResponse($form);
        }

        return [
            'form' => $form
        ];
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
        $accessor   = PropertyAccess::createPropertyAccessor();
        $parameters = $request->request->all();
        $boxType    = $accessor->getValue($parameters, '[required_data][boxType]');

        return $accessor->getValue($parameters, '[' . $boxType . ']');
    }
}
