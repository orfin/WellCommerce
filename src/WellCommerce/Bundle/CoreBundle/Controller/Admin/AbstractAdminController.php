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

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use WellCommerce\Bundle\CoreBundle\Controller\AbstractController;
use WellCommerce\Bundle\CoreBundle\Controller\Admin\Manager\AdminManagerInterface;
use WellCommerce\Bundle\CoreBundle\Repository\RepositoryInterface;
use WellCommerce\Bundle\DataGridBundle\DataGrid\DataGridInterface;
use WellCommerce\Bundle\FormBundle\Form\FormInterface;

/**
 * Class AbstractAdminController
 *
 * @package WellCommerce\Bundle\CoreBundle\Controller
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 *
 * @Template()
 */
abstract class AbstractAdminController extends AbstractController implements AdminControllerInterface
{
    /**
     * @var DataGridInterface
     */
    protected $datagrid;

    /**
     * @var RepositoryInterface
     */
    protected $repository;

    /**
     * @var FormInterface
     */
    protected $form;

    /**
     * @var AdminManagerInterface
     */
    protected $manager;

    /**
     * Constructor
     *
     * @param ContainerInterface       $container
     * @param null|RepositoryInterface $repository
     * @param null|DataGridInterface   $datagrid
     * @param null|FormInterface       $form
     * @param AdminManagerInterface    $manager
     */
    public function __construct(
        ContainerInterface $container,
        AdminManagerInterface $manager,
        RepositoryInterface $repository = null,
        DataGridInterface $datagrid = null,
        FormInterface $form = null
    ) {
        $this->setContainer($container);
        $this->repository = $repository;
        $this->datagrid   = $datagrid;
        $this->form       = $form;
        $this->manager    = $manager;
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
            'datagrid' => $this->datagrid->getDataGrid()
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
        return new JsonResponse($this->datagrid->getDataGrid()->load($request));
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
        $resource = $this->repository->createNew();
        $form     = $this->getForm($resource);

        if ($form->handleRequest($request)->isValid()) {
            $this->manager->create($resource, $request);

            return $this->manager->getRedirectHelper()->redirectToAction('index');
        }

        return [
            'form' => $form
        ];
    }

    /**
     * Returns a form for particular resource
     *
     * @param $resource
     *
     * @return \WellCommerce\Bundle\FormBundle\Form\Elements\Form
     */
    protected function getForm($resource)
    {
        return $this->getFormBuilder($this->form, $resource, [
            'name' => $this->repository->getAlias()
        ]);
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
        $em = $this->getEntityManager();

        try {
            $resource = $this->repository->find($id);
            $em->remove($resource);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()]);
        }

        $em->flush();

        return new JsonResponse(['success' => true]);
    }
}