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
namespace WellCommerce\Bundle\CoreBundle\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use WellCommerce\Bundle\CoreBundle\AbstractComponent;
use WellCommerce\Bundle\CoreBundle\DataGrid\DataGridInterface;
use WellCommerce\Bundle\CoreBundle\DataSet\DataSetInterface;
use WellCommerce\Bundle\CoreBundle\Form\Builder\FormBuilderInterface;
use WellCommerce\Bundle\CoreBundle\Form\FormInterface;
use WellCommerce\Bundle\CoreBundle\Repository\RepositoryInterface;

/**
 * Class Controller
 *
 * @package WellCommerce\Bundle\CoreBundle\Controller
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
     * Creates and returns the form element
     *
     * @param FormInterface $form    Form instance
     * @param null|object   $model   Model instance
     * @param array         $options Form options
     *
     * @return \WellCommerce\Bundle\CoreBundle\Form\Elements\Form
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
     * @return \WellCommerce\Bundle\CoreBundle\DataGrid\DataGridInterface
     */
    public function getDataGrid(DataGridInterface $dataGrid)
    {
        return $this->get('datagrid_builder')->create($dataGrid);
    }

    /**
     * Creates and returns the dataset
     *
     * @param DataSetInterface $dataSet DataSet instance
     *
     * @return \WellCommerce\Bundle\CoreBundle\DataSet\DataSetInterface
     */
    public function getDataSet(DataSetInterface $dataSet)
    {
        return $this->get('dataset_builder')->create($dataSet);
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