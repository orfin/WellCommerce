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

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use WellCommerce\Bundle\CoreBundle\DataGrid\DataGridInterface;
use WellCommerce\Bundle\CoreBundle\DependencyInjection\AbstractContainer;
use WellCommerce\Bundle\CoreBundle\Form\FormInterface;

/**
 * Class Controller
 *
 * @package WellCommerce\Bundle\CoreBundle\Controller
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractController extends AbstractContainer
{
    /**
     * Creates and returns the form element
     *
     * @param FormInterface $form    Form instance
     * @param null|object   $data    Initial form data
     * @param array         $options Form options
     *
     * @return \WellCommerce\Bundle\CoreBundle\Form\Elements\Form
     */
    protected function getFormBuilder(FormInterface $form, $data = null, array $options)
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
    protected function getDataGrid(DataGridInterface $dataGrid)
    {
        return $this->get('datagrid_builder')->create($dataGrid);
    }

    /**
     * Returns current user
     *
     * @return \WellCommerce\Bundle\UserBundle\Entity\User
     */
    protected function getUser()
    {
        return $this->get('security.context')->getToken()->getUser();
    }

    public function jsonResponse($content)
    {
        return new JsonResponse($content);
    }
}