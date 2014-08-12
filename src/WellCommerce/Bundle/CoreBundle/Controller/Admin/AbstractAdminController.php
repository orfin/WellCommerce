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
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Validator\Exception\ValidatorException;
use WellCommerce\Bundle\CoreBundle\Controller\AbstractController;
use WellCommerce\Bundle\CoreBundle\DataGrid\DataGridInterface;
use WellCommerce\Bundle\CoreBundle\Form\FormInterface;
use WellCommerce\Bundle\CoreBundle\Repository\RepositoryInterface;

/**
 * Class AbstractAdminController
 *
 * @package WellCommerce\Bundle\CoreBundle\Controller
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractAdminController extends AbstractController implements AdminControllerInterface
{
    /**
     * @var \WellCommerce\Bundle\CoreBundle\Helper\Flash\FlashHelper
     */
    protected $flashHelper;

    /**
     * @var \WellCommerce\Bundle\CoreBundle\Helper\Redirect\RedirectHelperInterface
     */
    protected $redirectHelper;

    /**
     * @var DataGridInterface
     */
    protected $dataGrid;

    /**
     * @var RepositoryInterface
     */
    protected $repository;

    /**
     * @var FormInterface
     */
    protected $form;

    /**
     * @var \Doctrine\Common\Persistence\ObjectManager
     */
    protected $objectManager;

    /**
     * Constructor
     *
     * @param ContainerInterface  $container
     * @param RepositoryInterface $repository
     * @param DataGridInterface   $dataGrid
     * @param FormInterface       $form
     */
    public function __construct(
        ContainerInterface $container,
        RepositoryInterface $repository,
        DataGridInterface $dataGrid,
        FormInterface $form
    ) {
        $this->setContainer($container);
        $this->flashHelper    = $container->get('flash_helper');
        $this->redirectHelper = $container->get('redirect_helper');
        $this->repository     = $repository;
        $this->dataGrid       = $dataGrid;
        $this->form           = $form;
        $this->objectManager  = $container->get('doctrine')->getManager();
    }

    public function getForm($resource)
    {
        return $this->getFormBuilder($this->form, $resource, [
            'name' => 'company'
        ]);
    }

    /**
     * Updates a resource
     *
     * @param $resource
     *
     * @return mixed
     */
    protected function saveResource($resource)
    {
        $this->objectManager->persist($resource);
        $this->objectManager->flush();

        return $resource;
    }

    public function indexAction()
    {
        return [
            'datagrid' => $this->getDataGrid($this->dataGrid)
        ];
    }

    public function addAction(Request $request)
    {
        $resource = $this->repository->createNew();
        $form     = $this->getForm($resource);

        if ($form->handleRequest($request)->isValid()) {
            try {
                $this->saveResource($resource);
                $this->flashHelper->addSuccess('success');

                return $this->redirectHelper->redirectToAction('index');

            } catch (ValidatorException $exception) {
                $this->flashHelper->addError($exception->getMessage());
            }
        }

        return [
            'form' => $form
        ];
    }

    public function editAction(Request $request)
    {
        $resource = $this->findOrFail($request);
        $form     = $this->getForm($resource);

        if ($form->handleRequest($request)->isValid()) {
            try {
                $this->saveResource($resource);
                $this->flashHelper->addSuccess('success');
                if ($form->isAction('continue')) {
                    return $this->redirectHelper->redirectToAction('edit', ['id' => $resource->getId()]);
                }

                return $this->redirectHelper->redirectToAction('index');

            } catch (ValidatorException $exception) {
                $this->flashHelper->addError($exception->getMessage());
            }
        }

        return [
            'form' => $form
        ];
    }

    protected function findOrFail(Request $request, array $criteria = [])
    {
        $params = [];
        if ($request->attributes->has('id')) {
            $params = [
                'id' => $request->attributes->get('id')
            ];
        }
        if ($request->attributes->has('slug')) {
            $params = [
                'slug' => $request->attributes->get('slug')
            ];
        }

        $criteria = array_merge($params, $criteria);

        if (!$resource = $this->repository->findOneBy($criteria)) {
            throw new NotFoundHttpException('Resource not found');
        }

        return $resource;
    }
}