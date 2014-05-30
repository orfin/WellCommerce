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
namespace WellCommerce\Plugin\Availability\Controller\Admin;

use WellCommerce\Core\Component\Controller\AbstractAdminController;
use WellCommerce\Plugin\Availability\DataGrid\Config;
use WellCommerce\Plugin\Availability\Form\AvailabilityDataConverter;
use WellCommerce\Plugin\Availability\Model\AvailabilityData;
use WellCommerce\Plugin\Availability\Repository\AvailabilityRepositoryInterface;

/**
 * Class AvailabilityController
 *
 * @package WellCommerce\Plugin\Availability\Controller\Admin
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AvailabilityController extends AbstractAdminController
{
    private $repository;
    /**
     * {@inheritdoc}
     */
    public function indexAction()
    {
        return [
            'datagrid' => $this->createDataGrid($this->get('availability.datagrid'))
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function addAction()
    {
        $form = $this->createForm($this->get('availability.form'), null, [
            'name' => 'add_availability'
        ]);

        if ($form->isValid()) {
            $this->repository->save($form->getSubmitValuesFlat());

            return $this->redirect($this->getDefaultUrl());
        }

        return [
            'form' => $form
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function editAction($id)
    {
        $model = $this->repository->find($id);

        $form = $this->createForm($this->get('availability.form'), $model, [
            'name' => 'edit_availability'
        ]);

        if ($form->isValid()) {
            $this->repository->save($form->getSubmitValuesFlat(), $id);

            return $this->redirect($this->getDefaultUrl());
        }

        return [
            'availability' => $model,
            'form'         => $form
        ];
    }

    /**
     * Sets availability repository object
     *
     * @param AvailabilityRepositoryInterface $repository
     */
    public function setRepository(AvailabilityRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
}
