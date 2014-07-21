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
namespace WellCommerce\Attribute\Controller\Admin;

use Symfony\Component\Validator\Exception\ValidatorException;
use WellCommerce\Core\Controller\Admin\AbstractAdminController;
use WellCommerce\Attribute\Repository\AttributeRepositoryInterface;

/**
 * Class AttributeController
 *
 * @package WellCommerce\Attribute\Controller\Admin
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
        $this->getXajaxManager()->registerFunction([
            'AddGroup',
            $this->repository,
            'addAttributeGroup'
        ]);

        $groups = $this->repository->all();

        if (!$groups->isEmpty()) {
            return $this->redirect($this->generateUrl('admin.attribute.edit', ['id' => $groups->first()->id]));
        }

        return [
            'groups' => $this->repository->all()
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function addAction()
    {
        throw new \LogicException($this->trans('Attribute editor does not have typical "addAction". Instead of it xajax call is used to create new attribute groups.'));
    }

    /**
     * {@inheritdoc}
     */
    public function editAction($id)
    {
        $model = $this->repository->find($id);

        $form = $this->createForm($this->get('attribute.form'), $model, [
            'name'  => 'attribute_group',
            'class' => 'attributeGroupEditor'
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
            'groups'    => $this->repository->all(),
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
