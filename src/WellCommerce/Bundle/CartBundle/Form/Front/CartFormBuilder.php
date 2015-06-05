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
namespace WellCommerce\Bundle\CartBundle\Form\Front;

use WellCommerce\Bundle\FormBundle\Builder\AbstractFormBuilder;
use WellCommerce\Bundle\FormBundle\Builder\FormBuilderInterface;
use WellCommerce\Bundle\FormBundle\DataTransformer\EntityToIdentifierTransformer;
use WellCommerce\Bundle\FormBundle\Elements\FormInterface;

/**
 * Class CartFormBuilder
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CartFormBuilder extends AbstractFormBuilder implements FormBuilderInterface
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormInterface $form)
    {
        $form->addChild($this->getElement('radio_group', [
            'name'        => 'shippingMethod',
            'label'       => $this->trans('cart.label.shipping_method'),
            'options'     => $this->get('shipping_method.collection.front')->getSelect(),
            'transformer' => new EntityToIdentifierTransformer($this->get('shipping_method.repository'))
        ]));

        $form->addFilter($this->getFilter('no_code'));
        $form->addFilter($this->getFilter('trim'));
        $form->addFilter($this->getFilter('secure'));
    }
}
