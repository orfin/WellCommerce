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

/**
 * Class UserLoginForm
 *
 * @package WellCommerce\Bundle\UserBundle\Form
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
            'label' => $this->trans('admin.username'),
        ]));

        $form->addChild($builder->getElement('password', [
            'name'  => '_password',
            'label' => $this->trans('admin.password'),
        ]));

        $form->addChild($builder->getElement('submit', [
            'name'  => 'log_in',
            'label' => $this->trans('admin.log_id')
        ]));

        $form->addFilter('no_code');
        $form->addFilter('trim');
        $form->addFilter('secure');

        return $form;
    }
}
