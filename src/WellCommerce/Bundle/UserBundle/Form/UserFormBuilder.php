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

use WellCommerce\Bundle\FormBundle\Builder\AbstractFormBuilder;
use WellCommerce\Bundle\FormBundle\Builder\FormBuilderInterface;
use WellCommerce\Bundle\FormBundle\Elements\FormInterface;

/**
 * Class UserFormBuilder
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class UserFormBuilder extends AbstractFormBuilder implements FormBuilderInterface
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormInterface $form)
    {
        $requiredData = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'required_data',
            'label' => $this->trans('form.label.required_data')
        ]));

        $requiredData->addChild($this->getElement('text_field', [
            'name'  => 'firstName',
            'label' => $this->trans('user.label.first_name'),
        ]));

        $requiredData->addChild($this->getElement('text_field', [
            'name'  => 'lastName',
            'label' => $this->trans('user.label.last_name'),
        ]));

        $requiredData->addChild($this->getElement('text_field', [
            'name'  => 'username',
            'label' => $this->trans('user.label.username'),
        ]));

        $requiredData->addChild($this->getElement('text_field', [
            'name'  => 'email',
            'label' => $this->trans('user.label.email'),
        ]));

        $form->addFilter($this->getFilter('no_code'));
        $form->addFilter($this->getFilter('trim'));
        $form->addFilter($this->getFilter('secure'));
    }
}
