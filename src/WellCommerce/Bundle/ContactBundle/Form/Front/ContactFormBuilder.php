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
namespace WellCommerce\Bundle\ContactBundle\Form\Front;

use WellCommerce\Bundle\CoreBundle\Form\AbstractFormBuilder;
use WellCommerce\Component\Form\Elements\FormInterface;

/**
 * Class ContactFormBuilder
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ContactFormBuilder extends AbstractFormBuilder
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormInterface $form)
    {

        $form->addChild($this->getElement('text_field', [
            'name'  => 'email',
            'label' => $this->trans('contact_ticket.label.email'),
        ]));

        $form->addChild($this->getElement('text_field', [
            'name'  => 'subject',
            'label' => $this->trans('contact_ticket.label.subject'),
        ]));

        $form->addChild($this->getElement('text_area', [
            'name'  => 'content',
            'label' => $this->trans('contact_ticket.label.content'),
            'rows'  => 5,
            'cols'  => 10
        ]));

        $form->addFilter($this->getFilter('no_code'));
        $form->addFilter($this->getFilter('trim'));
        $form->addFilter($this->getFilter('secure'));
    }
}
