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
namespace WellCommerce\Plugin\Attribute\Controller\Admin;

use Symfony\Component\Validator\Exception\ValidatorException;
use WellCommerce\Core\Component\Controller\Admin\AbstractAdminController;
use WellCommerce\Plugin\Attribute\Repository\AttributeRepositoryInterface;

/**
 * Class AttributeController
 *
 * @package WellCommerce\Plugin\Attribute\Controller\Admin
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AttributeController extends AbstractAdminController
{
    /**
     * @var AttributeRepositoryInterface $repository
     */
    private $repository;

    /**
     * {@inheritdoc}
     */
    public function indexAction()
    {
        $form = $this->createForm($this->get('attribute.form'), null, [
            'name'  => 'attribute_group',
            'class' => 'attributeGroupEditor'
        ]);

        return [
            'form' => $form
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function addAction()
    {
        $form = $this->createForm($this->get('attribute.form'), null, [
            'name' => 'attribute'
        ]);

        if ($form->isValid()) {
            try {
                $this->repository->save($form->getSubmitValuesFlat());
                $this->addSuccessMessage('Changes saved successfully.');

                return $this->redirect($this->getDefaultUrl());

            } catch (ValidatorException $exception) {
                $this->addErrorMessage($exception->getMessage());
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

        $form = $this->createForm($this->get('attribute.form'), $model, [
            'name' => 'attribute',
        ]);

        if ($form->isValid()) {
            try {
                $this->repository->save($form->getSubmitValuesFlat(), $id);
                $this->addSuccessMessage('Changes saved successfully.');

                return $this->redirect($this->getDefaultUrl());

            } catch (ValidatorException $exception) {
                $this->addErrorMessage($exception->getMessage());
            }
        }

        return [
            'attribute' => $model,
            'form'      => $form
        ];
    }

    /**
     * Sets attribute repository object
     *
     * @param AttributeRepositoryInterface $repository
     */
    public function setRepository(AttributeRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
}
