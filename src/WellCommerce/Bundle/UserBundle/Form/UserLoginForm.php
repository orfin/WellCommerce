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
use WellCommerce\Bundle\CoreBundle\Form\Elements\FormInterface;

/**
 * Class UserLoginForm
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class UserLoginForm extends AbstractForm implements FormInterface
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $form = $builder->init($options);

        $form->addChild($builder->getElement('text_field', [
            'name'  => '_username',
            'label' => $this->trans('user_login.username.label'),
            'rules' => [
                $builder->getRule('required',[
                    'message' => $this->trans('user_login.username.error.required')
                ])
            ]
        ]));

        $form->addChild($builder->getElement('password', [
            'name'  => '_password',
            'label' => $this->trans('user_login.password.label'),
            'rules' => [
                $builder->getRule('required',[
                    'message' => $this->trans('user_login.password.error.required')
                ])
            ]
        ]));

        $form->addChild($builder->getElement('submit', [
            'name'  => 'log_in',
            'label' => $this->trans('user_login.log_in.label'),
        ]));

        $form->addFilter($builder->getFilter('no_code'));
        $form->addFilter($builder->getFilter('trim'));
        $form->addFilter($builder->getFilter('secure'));

        return $form;
    }
}
