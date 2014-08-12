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

namespace WellCommerce\Bundle\ClientBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Exception\ValidatorException;
use WellCommerce\Bundle\ClientBundle\DataGrid\ClientGroupDataGrid;
use WellCommerce\Bundle\ClientBundle\Entity\ClientGroup;
use WellCommerce\Bundle\ClientBundle\Repository\ClientGroupRepositoryInterface;
use WellCommerce\Bundle\CoreBundle\Controller\Admin\AbstractAdminController;
use WellCommerce\Bundle\CoreBundle\Controller\Admin\Traits\DataGrid;

/**
 * Class ClientGroupController
 *
 * @package WellCommerce\Bundle\ClientBundle\Controller
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 *
 * @Template()
 */
class ClientGroupController extends AbstractAdminController
{
    public function indexAction()
    {
        return [
            'datagrid' => $this->getDataGrid($this->get('client_group.datagrid'))
        ];
    }

    public function gridAction($request)
    {
        print_r($request);
    }



    /**
     * Returns company form
     *
     * @param ClientGroup $clientGroup
     *
     * @return \WellCommerce\Bundle\CoreBundle\Form\Elements\Form
     */
    public function getClientGroupForm(ClientGroup $clientGroup)
    {
        return $this->getFormBuilder($this->get('client_group.form'), $clientGroup, [
            'name' => 'client_group'
        ]);
    }

    /**
     * Sets repository object
     *
     * @param ClientGroupRepositoryInterface $repository
     */
    public function setRepository(ClientGroupRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
}
