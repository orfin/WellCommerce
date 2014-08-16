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
namespace WellCommerce\Bundle\UserBundle\Form;

use WellCommerce\Bundle\CoreBundle\Form\AbstractForm;
use WellCommerce\Bundle\CoreBundle\Form\Builder\FormBuilderInterface;
use WellCommerce\Bundle\CoreBundle\Form\FormInterface;
use WellCommerce\Bundle\UserBundle\Repository\UserRepositoryInterface;

/**
 * Class UserForm
 *
 * @package WellCommerce\User\Form
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class UserForm extends AbstractForm implements FormInterface
{
    /**
     * @var UserRepositoryInterface
     */
    private $repository;

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $form = $builder->init($options);

        $requiredData = $form->addChild($builder->getElement('fieldset', [
            'name'  => 'required_data',
            'label' => $this->trans('form.required_data')
        ]));

        $requiredData->addChild($builder->getElement('select', [
            'name'    => 'code',
            'label'   => $this->trans('user.code'),
            'options' => $this->repository->getCurrenciesToSelect()
        ]));

        $form->addFilter('no_code');
        $form->addFilter('trim');
        $form->addFilter('secure');

        return $form;
    }

    /**
     * Sets user repository
     *
     * @param UserRepositoryInterface $repository
     */
    public function setRepository(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
}
