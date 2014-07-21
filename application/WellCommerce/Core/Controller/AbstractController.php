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
namespace WellCommerce\Core\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use WellCommerce\Core\AbstractComponent;
use WellCommerce\Core\DataGrid\DataGridInterface;
use WellCommerce\Core\Form\Builder\FormBuilderInterface;
use WellCommerce\Core\Form\FormInterface;
use WellCommerce\Core\Repository\RepositoryInterface;

/**
 * Class Controller
 *
 * @package WellCommerce\Core\Controller
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractController extends AbstractComponent
{
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
     * Creates a form
     *
     * @param FormInterface $form    Form instance
     * @param null          $model   Model instance
     * @param array         $options Form options
     *
     * @return \WellCommerce\Core\Form\FormInterface
     */
    public function createForm(FormInterface $form, $model = null, array $options)
    {
        return $this->get('form_builder')->create($form, $model, $options)->getForm();
    }

    /**
     * Creates and returns the datagrid
     *
     * @param DataGridInterface $dataGrid DataGrid instance
     *
     * @return \WellCommerce\Core\DataGrid\DataGridInterface
     */
    public function getDataGrid(DataGridInterface $dataGrid)
    {
        return $this->get('datagrid_builder')->create($dataGrid);
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