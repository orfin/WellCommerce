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
namespace WellCommerce\Bundle\AdminBundle\Form\Admin;

use WellCommerce\Bundle\CoreBundle\Form\AbstractFormBuilder;
use WellCommerce\Component\Form\Elements\FormInterface;

/**
 * Class UserLoginFormBuilder
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class UserLoginFormBuilder extends AbstractFormBuilder
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormInterface $form)
    {
        $form->addChild($this->getElement('text_field', [
            'name'  => '_username',
            'label' => $this->trans('user.label.username'),
            'rules' => [
                $this->getRule('required')
            ],
        ]));

        $form->addChild($this->getElement('password', [
            'name'  => '_password',
            'label' => $this->trans('user.label.password'),
            'rules' => [
                $this->getRule('required')
            ],
        ]));

        $form->addChild($this->getElement('submit', [
            'name'  => 'log_in',
            'label' => $this->trans('user.button.log_in'),
        ]));

        $resetUrl = $this->getRouterHelper()->generateUrl('admin.user.reset_password');

        $form->addChild($this->getElement('static_text', [
            'text' => '<a href="' . $resetUrl . '">' . $this->trans('user.button.reset_password') . '</a>',
        ]));

        $form->addFilter($this->getFilter('no_code'));
        $form->addFilter($this->getFilter('trim'));
        $form->addFilter($this->getFilter('secure'));
    }
}
