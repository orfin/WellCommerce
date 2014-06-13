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
namespace WellCommerce\Plugin\Contact\Controller\Admin;

use Symfony\Component\Validator\Exception\ValidatorException;
use WellCommerce\Core\Component\Controller\AbstractAdminController;
use WellCommerce\Plugin\Contact\Repository\ContactRepositoryInterface;

/**
 * Class ContactController
 *
 * @package WellCommerce\Plugin\Contact\Controller\Admin
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ContactController extends AbstractAdminController
{
    private $repository;

    /**
     * {@inheritdoc}
     */
    public function indexAction()
    {
        return [
            'datagrid' => $this->createDataGrid($this->get('contact.datagrid'))
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function addAction()
    {
        $form = $this->createForm($this->get('contact.form'), null, [
            'name' => 'add_contact',
        ]);

        if ($form->isValid()) {
            try {
                $this->repository->save($form->getSubmitValuesFlat());
                $this->addSuccessMessage('Changes saved successfully.');

                return $this->redirect($this->getDefaultUrl());

            } catch (ValidatorException $exception) {
                $this->addErrorMessage($exception->getMessage());
                $this->getFlashBag()->add(self::MESSAGE_TYPE_ERROR, $this->trans($exception->getMessage()));
            }
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

        $form = $this->createForm($this->get('contact.form'), $model, [
            'name' => 'edit_contact',
        ]);

        if ($form->isValid()) {
            try {
                $this->repository->save($form->getSubmitValuesFlat(), $id);
                $this->addSuccessMessage('Changes saved successfully.');

                if ($form->isAction('continue')) {
                    return $this->redirect($this->generateUrl('admin.contact.edit', ['id' => $model->id]));
                }

                return $this->redirect($this->getDefaultUrl());

            } catch (ValidatorException $exception) {
                $this->addErrorMessage($exception->getMessage());
            }
        }

        return [
            'contact' => $model,
            'form'    => $form
        ];
    }

    /**
     * Sets contact repository object
     *
     * @param ContactRepositoryInterface $repository
     */
    public function setRepository(ContactRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
}
