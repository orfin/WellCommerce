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
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use WellCommerce\Bundle\CoreBundle\Controller\Admin\AbstractAdminController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Class AttributeGroupController
 *
 * @package WellCommerce\Bundle\AttributeBundle\Controller\Admin
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 *
 * @Template()
 */
class AttributeGroupController extends AbstractAdminController
{
    /**
     * @var \WellCommerce\Bundle\AttributeBundle\Repository\AttributeGroupRepositoryInterface
     */
    protected $repository;

    /**
     * {@inheritdoc}
     */
    public function indexAction(Request $request)
    {
        $groups = $this->repository->findAll();

        if (count($groups) > 0) {
            $firstGroup = current($groups);

            return $this->manager->getRedirectHelper()->redirectToAction('edit', ['id' => $firstGroup['id']]);
        }

        return [
            'groups' => $groups
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function addAction(Request $request)
    {
        $group = $this->repository->addAttributeGroup($request->request);

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
     * Returns all attribute groups as json
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function ajaxIndexAction(Request $request)
    {
        // prevent direct access and redirect administrator to index
        if (!$request->isXmlHttpRequest()) {
            return $this->manager->getRedirectHelper()->redirectToAction('index');
        }

        $groups = $this->repository->findAll();
        $sets   = [];

        foreach ($groups as $group) {
            $sets[] = [
                'id'               => $group['id'],
                'name'             => $group['name'],
                'current_category' => false
            ];
        }

        $response = [
            'sets' => $sets
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
