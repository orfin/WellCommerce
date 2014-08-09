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

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use WellCommerce\Bundle\CoreBundle\DataGrid\DataGridInterface;
use WellCommerce\Bundle\CoreBundle\DataSet\DataSetInterface;
use WellCommerce\Bundle\CoreBundle\Form\FormInterface;

/**
 * Class Controller
 *
 * @package WellCommerce\Bundle\CoreBundle\Controller
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractController extends Controller
{
    /**
     * Shortcut to return the session flashbag
     *
     * @return object FlashBag from session service
     */
    protected function getFlashBag()
    {
        return $this->container->get('session')->getFlashBag();
    }

    /**
     * Translates a string using the translation service
     *
     * @param string $id Message to translate
     *
     * @return string The message
     */
    protected function trans($id)
    {
        return $this->container->get('translator')->trans($id);
    }

    /**
     * Creates and returns the form element
     *
     * @param FormInterface $form    Form instance
     * @param null|object   $data    Initial form data
     * @param array         $options Form options
     *
     * @return \WellCommerce\Bundle\CoreBundle\Form\Elements\Form
     */
    public function getFormBuilder(FormInterface $form, $data = null, array $options)
    {
        return $this->get('form.builder')->create($form, $data, $options)->getForm();
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
}