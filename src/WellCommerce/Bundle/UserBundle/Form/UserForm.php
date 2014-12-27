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
use WellCommerce\Bundle\MediaBundle\Form\DataTransformer\MediaEntityToIdentifierTransformer;
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

        $requiredData->addChild($builder->getElement('text_field', [
            'name'  => 'firstName',
            'label' => $this->trans('user.firstName'),
        ]));

        $requiredData->addChild($builder->getElement('text_field', [
            'name'  => 'lastName',
            'label' => $this->trans('user.lastName'),
        ]));

        $requiredData->addChild($builder->getElement('text_field', [
            'name'  => 'username',
            'label' => $this->trans('user.username'),
        ]));

        $requiredData->addChild($builder->getElement('text_field', [
            'name'  => 'email',
            'label' => $this->trans('user.email'),
        ]));

        $mediaData = $form->addChild($builder->getElement('fieldset', [
            'name'  => 'media_data',
            'label' => $this->trans('Media')
        ]));

        $mediaData->addChild($builder->getElement('image', [
            'name'        => 'photo',
            'label'       => $this->trans('Avatar'),
            'load_route'  => $this->generateUrl('admin.media.grid'),
            'upload_url'  => $this->generateUrl('admin.media.add'),
            'repeat_min'  => 0,
            'repeat_max'  => 1,
            'transformer' => new MediaEntityToIdentifierTransformer($this->get('media.repository'))
        ]));

        $form->addFilter($builder->getFilter('no_code'));
        $form->addFilter($builder->getFilter('trim'));
        $form->addFilter($builder->getFilter('secure'));

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
