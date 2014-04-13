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
use WellCommerce\Plugin\Availability\Event\AvailabilityFormEvent;
use WellCommerce\Plugin\Availability\Form\AvailabilityDataTransformer;
use WellCommerce\Plugin\Availability\Form\AvailabilityForm;
use WellCommerce\Plugin\Availability\Model\Availability;

/**
 * Class AvailabilityController
 *
 * @package WellCommerce\Plugin\Availability\Controller\Admin
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AvailabilityController extends AbstractAdminController
{
    public function indexAction()
    {
        $grid = $this->get('availability.datagrid');

        $datagrid = $this->createDataGrid($grid, [
            'id'             => 'availability',
            'event_handlers' => [
                'load'       => $this->getXajaxManager()->registerFunction(['LoadAvailability', $grid, 'loadData']),
                'edit_row'   => 'editAvailability',
                'click_row'  => 'editAvailability',
                'delete_row' => $this->getXajaxManager()->registerFunction(['DeleteAvailability', $grid, 'deleteRow']),
            ],
            'routes'         => [
                'edit' => $this->generateUrl('admin.availability.edit')
            ]
        ]);

        return [
            'datagrid' => $datagrid
        ];
    }

    public function addAction()
    {
        $form = $this->createForm($this->get('availability.form'), null, [
            'name'   => 'availability',
            'method' => 'POST',
            'action' => $this->generateUrl('admin.availability.add')
        ]);

        if ($form->isValid()) {
            $this->repository->save($form->getSubmittedData());

            return $this->redirect($this->generateUrl('admin.availability.index'));
        }

        return [
            'form' => $form
        ];
    }

    public function editAction($id)
    {
        $model = $this->repository->find($id);

        $form = $this->createForm($this->get('availability.form'), $model, [
            'name'   => 'availability',
            'method' => 'POST',
            'action' => $this->generateUrl('admin.availability.edit', ['id' => $model->id])
        ]);

        if ($form->isValid()) {
            $this->repository->save($form->getSubmittedData(), $id);

            return $this->redirect($this->generateUrl('admin.availability.index'));
        }

        return [
            'model' => $model,
            'form'  => $form
        ];
    }
}
