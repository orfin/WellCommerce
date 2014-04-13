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
namespace WellCommerce\Core\Component\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use WellCommerce\Core\Component\AbstractComponent;
use WellCommerce\Core\Component\DataGrid\DataGridInterface;
use WellCommerce\Core\Component\Form\FormBuilderInterface;
use WellCommerce\Core\Component\Form\FormInterface;
use WellCommerce\Core\Component\Repository\RepositoryInterface;

/**
 * Class Controller
 *
 * @package WellCommerce\Core\Component\Controller
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractController extends AbstractComponent
{
    /**
     * @var Repository object
     */
    protected $repository;

    /**
     * @var DataGrid object
     */
    protected $datagrid;

    /**
     * Redirects user to a given url
     *
     * @param string $url
     * @param number $status
     *
     * @return RedirectResponse
     */
    public function redirect($url, $status = 302)
    {
        return new RedirectResponse($url, $status);
    }

    /**
     * Sets Repository object for current controller
     *
     * @param RepositoryInterface $repository
     */
    public function setRepository(RepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Creates a form
     *
     * @param FormInterface  $form    Form instance
     * @param ModelInterface $model   Model instance
     * @param array          $options Form options
     *
     * @return mixed
     */
    public function createForm(FormInterface $form, $model = null, array $options)
    {
        return $this->get('form_builder')->create($form, $model, $options)->getForm();
    }

    /**
     * Creates a datagrid
     *
     * @param DataGridInterface $dataGrid DataGrid instance
     * @param array             $options  DataGrid options
     *
     * @return mixed
     */
    public function createDataGrid(DataGridInterface $dataGrid, array $options)
    {
        return $this->get('datagrid_builder')->create($dataGrid, $options)->getDataGrid();
    }

    /**
     * Returns a NotFoundHttpException.
     *
     * @param string     $message  A message
     * @param \Exception $previous The previous exception
     *
     * @return NotFoundHttpException
     */
    public function createNotFoundException($message = 'Not Found', \Exception $previous = null)
    {
        return new NotFoundHttpException($message, $previous);
    }
}