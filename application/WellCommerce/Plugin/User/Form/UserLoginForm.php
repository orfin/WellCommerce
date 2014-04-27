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
namespace WellCommerce\Plugin\User\Form;

use WellCommerce\Core\Component\Form\AbstractForm;
use WellCommerce\Core\Component\Form\FormBuilder;
use WellCommerce\Core\Component\Form\FormInterface;
use WellCommerce\Core\Component\Model\ModelInterface;
use WellCommerce\Plugin\User\Model\User;

/**
 * Class UserLoginForm
 *
 * @package WellCommerce\Plugin\User\Form
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class UserLoginForm extends AbstractForm implements FormInterface
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilder $builder, array $options)
    {
        $form = $builder->addForm($options);

        $form->addChild($builder->addTextField([
            'name'  => 'email',
            'label' => $this->trans('E-mail'),
            'rules' => [
                $builder->addRuleRequired($this->trans('E-mail is required')),
            ]
        ]));

        $form->addChild($builder->addPassword([
            'name'  => 'password',
            'label' => $this->trans('Password'),
            'rules' => [
                $builder->addRuleRequired($this->trans('Password is required')),
            ]
        ]));

        $form->addChild($builder->addSubmitButton([
            'name'  => 'log_in',
            'label' => $this->trans('Log in')
        ]));

        $form->addFilters([
            $builder->addFilterNoCode(),
            $builder->addFilterTrim(),
            $builder->addFilterSecure()
        ]);

        return $form;
    }
}
