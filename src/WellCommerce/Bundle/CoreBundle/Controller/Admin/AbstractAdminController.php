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
namespace WellCommerce\Bundle\CoreBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use WellCommerce\Bundle\CoreBundle\Controller\AbstractController;
use WellCommerce\Bundle\CoreBundle\Manager\Admin\AdminManagerInterface;

/**
 * Class AbstractAdminController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 *
 * @Sensio\Bundle\FrameworkExtraBundle\Configuration\Template()
 */
abstract class AbstractAdminController extends AbstractController implements AdminControllerInterface
{
    /**
     * @var AdminManagerInterface
     */
    protected $manager;

    /**
     * Constructor
     *
     * @param AdminManagerInterface $manager
     */
    public function __construct(AdminManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Controller index action
     *
     * @param Request $request
     *
     * @return array
     */
    public function indexAction(Request $request)
    {
        return [
            'datagrid' => $this->manager->getDataGrid()->getInstance()
        ];
    }

    /**
     * Default DataGrid view action
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function gridAction(Request $request)
    {
        $datagrid = $this->manager->getDataGrid()->getInstance();

        try {
            $results = $datagrid->loadResults($request);
        } catch (\Exception $e) {
            $results = nl2br($e->getMessage());
        }

        return $this->jsonResponse($results);
    }

    /**
     * Default add action
     *
     * @param Request $request
     *
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function addAction(Request $request)
    {
        $resource = $this->manager->getRepository()->createNew();
        $form     = $this->getForm($resource);

        if ($form->handleRequest($request)->isValid()) {
            $this->manager->createResource($resource, $request);

            if ($form->isAction('next')) {
                return $this->redirectToAction('add');
            }

            return $this->redirectToAction('index');
        }

        return [
            'form' => $form
        ];
    }

    /**
     * Returns a form for particular resource
     *
     * @param       $resource
     * @param array $config
     *
     * @return \WellCommerce\Bundle\CoreBundle\Form\Elements\Form
     */
    protected function getForm($resource, array $config = [])
    {
        $defaultConfig = [
            'name' => $this->manager->getRepository()->getAlias()
        ];

        $config = array_merge($defaultConfig, $config);

        return $this->getFormBuilder($this->manager->getForm(), $resource, $config);
    }

    /**
     * Default edit action
     *
     * @param Request $request
     *
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function editAction(Request $request)
    {
        $resource = $this->findOr404($request);
        $form     = $this->getForm($resource);

        if ($form->handleRequest($request)->isValid()) {
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

    /**
     * Default delete action
     *
     * @param $id
     *
     * @return JsonResponse
     */
    public function deleteAction($id)
    {
        try {
            $resource = $this->manager->getRepository()->find($id);
            $this->manager->removeResource($resource);
        } catch (\Exception $e) {
            return $this->jsonResponse(['error' => $e->getMessage()]);
        }

        return $this->jsonResponse(['success' => true]);
    }

    /**
     * Returns current resource or throws an exception
     *
     * @param Request $request
     *
     * @return mixed
     */
    protected function findOr404(Request $request)
    {
        $this->manager->getDoctrineHelper()->disableFilter('locale');

        if (!$request->attributes->has('id')) {
            throw new \LogicException('Request does not have "id" attribute set.');
        }

        $id = $request->attributes->get('id');

        if (null === $resource = $this->manager->getRepository()->find($id)) {
            throw new NotFoundHttpException(sprintf('Resource not found'));
        }

        return $resource;
    }
}