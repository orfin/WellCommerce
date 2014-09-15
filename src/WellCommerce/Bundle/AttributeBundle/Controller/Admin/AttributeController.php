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

namespace WellCommerce\Bundle\AttributeBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use WellCommerce\Bundle\CoreBundle\Controller\Admin\AbstractAdminController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Class AttributeController
 *
 * @package WellCommerce\Bundle\AttributeBundle\Controller\Admin
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 *
 * @Template()
 */
class AttributeController extends AbstractAdminController
{
    /**
     * @var \WellCommerce\Bundle\AttributeBundle\Repository\AttributeRepositoryInterface
     */
    protected $repository;

    /**
     * {@inheritdoc}
     */
    public function indexAction(Request $request)
    {
        // prevent direct access and redirect administrator to index
        if (!$request->isXmlHttpRequest()) {
            return $this->manager->getRedirectHelper()->redirectToAction('index');
        }

        $attributes = $this->repository->findAllByAttributeGroupId($request->request->get('id'));

        $sets = [];

        foreach ($attributes as $attribute) {
            $sets[] = [
                'id'     => $attribute['id'],
                'name'   => $attribute['name'],
                'values' => $attribute['values'],
            ];
        }

        $response = [
            'attributes' => $sets
        ];

        return $this->jsonResponse($response);
    }

    /**
     * {@inheritdoc}
     */
    public function addAction(Request $request)
    {
        $group = $this->repository->addAttribute($request->request);

        return $this->jsonResponse([
            'id' => $group->getId()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function editAction(Request $request)
    {
        $resource = $this->repository->findResource($request);
        $form     = $this->getForm($resource);

        if ($form->handleRequest($request)->isValid()) {
            $this->manager->update($resource, $request);
            if ($form->isAction('continue')) {
                return $this->manager->getRedirectHelper()->redirectToAction('edit', $resource);
            }

            return $this->manager->getRedirectHelper()->redirectToAction('index');
        }

        return [
            'currentGroup' => $resource,
            'groups'       => $this->repository->findAll(),
            'form'         => $form
        ];
    }

    /**
     * Returns all attributes for group
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function ajaxGetAttributesAction(Request $request)
    {
        // prevent direct access and redirect administrator to index
        if (!$request->isXmlHttpRequest()) {
            return $this->manager->getRedirectHelper()->redirectToAction('index');
        }

        $attributes = $this->repository->findAllByAttributeGroupId($request->request->get('id'));

        $sets = [];

        foreach ($attributes as $attribute) {
            $sets[] = [
                'id'     => $attribute['id'],
                'name'   => $attribute['name'],
                'values' => $attribute['values'],
            ];
        }

        $response = [
            'attributes' => $sets
        ];

        return $this->jsonResponse($response);
    }

    /**
     * {@inheritdoc}
     */
    protected function getForm($resource)
    {
        return $this->getFormBuilder($this->form, $resource, [
            'name'  => $this->repository->getAlias(),
            'class' => 'attributeGroupEditor'
        ]);
    }
}
