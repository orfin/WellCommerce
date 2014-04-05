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
use WellCommerce\Core\Component\AbstractComponent;
use WellCommerce\Core\Component\DataGrid\DataGridInterface;
use WellCommerce\Core\Component\Form\FormBuilderInterface;
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
     * @var FormBuilder object
     */
    protected $formBuilder;

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
     * Sets FormBuilder object for current controller
     *
     * @param FormBuilderInterface $formBuilder
     */
    public function setFormBuilder(FormBuilderInterface $formBuilder)
    {
        $this->formBuilder = $formBuilder;
    }

    /**
     * Sets DataGrid object for current controller
     *
     * @param DataGridInterface $datagrid
     */
    public function setDataGrid(DataGridInterface $datagrid)
    {
        $this->datagrid = $datagrid;
    }
}