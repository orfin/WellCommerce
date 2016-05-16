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
namespace WellCommerce\Bundle\OrderBundle\Form\Admin;

use WellCommerce\Bundle\CoreBundle\Form\AbstractFormBuilder;
use WellCommerce\Bundle\OrderBundle\Entity\OrderModifierInterface;
use WellCommerce\Bundle\OrderBundle\Provider\Admin\OrderProviderInterface;
use WellCommerce\Bundle\PaymentBundle\Entity\PaymentMethodInterface;
use WellCommerce\Bundle\ShippingBundle\Context\OrderContext;
use WellCommerce\Bundle\ShippingBundle\Entity\ShippingMethodCostInterface;
use WellCommerce\Bundle\ShippingBundle\Entity\ShippingMethodInterface;
use WellCommerce\Bundle\ShippingBundle\Provider\ShippingMethodProviderInterface;
use WellCommerce\Component\Form\Elements\ElementInterface;
use WellCommerce\Component\Form\Elements\FormInterface;
use WellCommerce\Component\Form\Elements\Optioned\Select;

/**
 * Class OrderFormBuilder
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
final class OrderFormBuilder extends AbstractFormBuilder
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormInterface $form)
    {
        $order     = $this->getOrderProvider()->getCurrentOrder();
        $countries = $this->get('country.repository')->all();

        $requiredData = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'required_data',
            'label' => $this->trans('order.form.fieldset.products'),
        ]));

        $requiredData->addChild($this->getElement('order_editor', [
            'name'                => 'products',
            'label'               => $this->trans('order.heading.products'),
            'repeat_min'          => 1,
            'repeat_max'          => ElementInterface::INFINITE,
            'load_products_route' => 'admin.product.grid',
            'on_change'           => 'OnProductListChange',
            'on_before_change'    => 'OnProductListBeforeChange',
            'transformer'         => $this->getRepositoryTransformer('order_product_collection', $this->get('order_product.repository'))
        ]));

        $orderDetails = $form->addChild($this->getElement('columns', [
            'name'  => 'orderMethodsDetails',
            'label' => $this->trans('order.heading.order_methods_details'),
        ]));

        $paymentShippingData = $orderDetails->addChild($this->getElement('nested_fieldset', [
            'name'  => 'methods',
            'label' => $this->trans('client.heading.billing_address'),
        ]));

        $shippingMethod = $paymentShippingData->addChild($this->getElement('select', [
            'name'        => 'shippingMethod',
            'label'       => $this->trans('order.label.shipping_method'),
            'transformer' => $this->getRepositoryTransformer('entity', $this->get('shipping_method.repository'))
        ]));

        $this->addShippingOptions($shippingMethod);

        $paymentMethod = $paymentShippingData->addChild($this->getElement('select', [
            'name'        => 'paymentMethod',
            'label'       => $this->trans('order.label.payment_method'),
            'transformer' => $this->getRepositoryTransformer('entity', $this->get('payment_method.repository'))
        ]));

        $this->addPaymentOptions($paymentMethod);

        $order->getModifiers()->map(function (OrderModifierInterface $modifier) use ($paymentShippingData) {
            $paymentShippingData->addChild($this->getElement('constant', [
                'name'  => 'summary.' . $modifier->getName(),
                'label' => $modifier->getDescription()
            ]))->setValue($modifier->getGrossAmount());
        });

        $summaryData = $orderDetails->addChild($this->getElement('nested_fieldset', [
            'name'  => 'summary',
            'label' => $this->trans('order.heading.order_total'),
        ]));

        $summaryData->addChild($this->getElement('constant', [
            'name'  => 'productTotal.netPrice',
            'label' => $this->trans('order.label.product_total.net_price'),
        ]));

        $summaryData->addChild($this->getElement('constant', [
            'name'  => 'productTotal.taxAmount',
            'label' => $this->trans('order.label.product_total.tax_amount'),
        ]));

        $summaryData->addChild($this->getElement('constant', [
            'name'  => 'productTotal.grossPrice',
            'label' => $this->trans('order.label.product_total.gross_price'),
        ]));

        $summaryData->addChild($this->getElement('constant', [
            'name'  => 'summary.netAmount',
            'label' => $this->trans('order.label.summary.net_amount'),
        ]));

        $summaryData->addChild($this->getElement('constant', [
            'name'  => 'summary.taxAmount',
            'label' => $this->trans('order.label.summary.tax_amount'),
        ]));

        $summaryData->addChild($this->getElement('constant', [
            'name'  => 'summary.grossAmount',
            'label' => $this->trans('order.label.summary.gross_amount'),
        ]));

        $contactDetails = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'contactDetails',
            'label' => $this->trans('order.heading.contact_details'),
        ]));

        $contactDetails->addChild($this->getElement('text_field', [
            'name'  => 'contactDetails.firstName',
            'label' => $this->trans('client.label.contact_details.first_name'),
        ]));

        $contactDetails->addChild($this->getElement('text_field', [
            'name'  => 'contactDetails.lastName',
            'label' => $this->trans('client.label.contact_details.last_name'),
        ]));

        $contactDetails->addChild($this->getElement('text_field', [
            'name'  => 'contactDetails.phone',
            'label' => $this->trans('client.label.contact_details.phone'),
        ]));

        $contactDetails->addChild($this->getElement('text_field', [
            'name'  => 'contactDetails.secondaryPhone',
            'label' => $this->trans('client.label.contact_details.secondary_phone'),
        ]));

        $contactDetails->addChild($this->getElement('text_field', [
            'name'  => 'contactDetails.email',
            'label' => $this->trans('client.label.contact_details.email'),
        ]));

        $addresses = $form->addChild($this->getElement('columns', [
            'name'  => 'addresses',
            'label' => $this->trans('order.heading.address'),
        ]));

        $billingAddress = $addresses->addChild($this->getElement('nested_fieldset', [
            'name'  => 'billingAddress',
            'label' => $this->trans('client.heading.billing_address'),
        ]));

        $billingAddress->addChild($this->getElement('text_field', [
            'name'  => 'billingAddress.firstName',
            'label' => $this->trans('client.label.address.first_name'),
        ]));

        $billingAddress->addChild($this->getElement('text_field', [
            'name'  => 'billingAddress.lastName',
            'label' => $this->trans('client.label.address.last_name'),
        ]));

        $billingAddress->addChild($this->getElement('text_field', [
            'name'  => 'billingAddress.line1',
            'label' => $this->trans('client.label.address.line1'),
        ]));

        $billingAddress->addChild($this->getElement('text_field', [
            'name'  => 'billingAddress.line2',
            'label' => $this->trans('client.label.address.line2'),
        ]));

        $billingAddress->addChild($this->getElement('text_field', [
            'name'  => 'billingAddress.postalCode',
            'label' => $this->trans('client.label.address.postal_code'),
        ]));

        $billingAddress->addChild($this->getElement('text_field', [
            'name'  => 'billingAddress.state',
            'label' => $this->trans('client.label.address.state'),
        ]));

        $billingAddress->addChild($this->getElement('text_field', [
            'name'  => 'billingAddress.city',
            'label' => $this->trans('client.label.address.city'),
        ]));

        $billingAddress->addChild($this->getElement('select', [
            'name'    => 'billingAddress.country',
            'label'   => $this->trans('client.label.address.country'),
            'options' => $countries,
        ]));

        $billingAddress->addChild($this->getElement('text_field', [
            'name'  => 'billingAddress.vatId',
            'label' => $this->trans('client.label.address.vat_id'),
        ]));

        $billingAddress->addChild($this->getElement('text_field', [
            'name'  => 'billingAddress.companyName',
            'label' => $this->trans('client.label.address.company_name'),
        ]));
        
        $shippingAddress = $addresses->addChild($this->getElement('nested_fieldset', [
            'name'  => 'shippingAddress',
            'label' => $this->trans('client.heading.shipping_address'),
        ]));

        $shippingAddress->addChild($this->getElement('text_field', [
            'name'  => 'shippingAddress.firstName',
            'label' => $this->trans('client.label.address.first_name'),
        ]));

        $shippingAddress->addChild($this->getElement('text_field', [
            'name'  => 'shippingAddress.lastName',
            'label' => $this->trans('client.label.address.last_name'),
        ]));

        $shippingAddress->addChild($this->getElement('text_field', [
            'name'  => 'shippingAddress.line1',
            'label' => $this->trans('client.label.address.line1'),
        ]));

        $shippingAddress->addChild($this->getElement('text_field', [
            'name'  => 'shippingAddress.line2',
            'label' => $this->trans('client.label.address.line2'),
        ]));

        $shippingAddress->addChild($this->getElement('text_field', [
            'name'  => 'shippingAddress.postalCode',
            'label' => $this->trans('client.label.address.postal_code'),
        ]));

        $shippingAddress->addChild($this->getElement('text_field', [
            'name'  => 'shippingAddress.state',
            'label' => $this->trans('client.label.address.state'),
        ]));

        $shippingAddress->addChild($this->getElement('text_field', [
            'name'  => 'shippingAddress.city',
            'label' => $this->trans('client.label.address.city'),
        ]));

        $shippingAddress->addChild($this->getElement('select', [
            'name'    => 'shippingAddress.country',
            'label'   => $this->trans('client.label.address.country'),
            'options' => $countries,
        ]));

        $form->addFilter($this->getFilter('no_code'));
        $form->addFilter($this->getFilter('trim'));
        $form->addFilter($this->getFilter('secure'));
    }

    private function getOrderProvider() : OrderProviderInterface
    {
        return $this->get('order.provider.admin');
    }

    private function getShippingMethodProvider() : ShippingMethodProviderInterface
    {
        return $this->get('shipping_method.provider');
    }

    /**
     * Adds shipping method options to select
     *
     * @param ElementInterface|Select $radioGroup
     */
    private function addShippingOptions(ElementInterface $radioGroup)
    {
        $order      = $this->getOrderProvider()->getCurrentOrder();
        $collection = $this->getShippingMethodProvider()->getCosts(new OrderContext($order));

        $collection->map(function (ShippingMethodCostInterface $shippingMethodCost) use ($radioGroup) {
            $shippingMethod = $shippingMethodCost->getShippingMethod();
            $baseCurrency   = $shippingMethod->getCurrency()->getCode();
            $grossAmount    = $shippingMethodCost->getCost()->getGrossAmount();

            $label = sprintf(
                '%s (%s)',
                $shippingMethod->translate()->getName(),
                $this->getCurrencyHelper()->convertAndFormat($grossAmount, $baseCurrency)
            );

            $radioGroup->addOptionToSelect($shippingMethod->getId(), $label);
        });
    }

    /**
     * Adds payment method options to select
     *
     * @param ElementInterface|Select $radioGroup
     */
    private function addPaymentOptions(ElementInterface $radioGroup)
    {
        $order          = $this->getOrderProvider()->getCurrentOrder();
        $shippingMethod = $order->getShippingMethod();
        if ($shippingMethod instanceof ShippingMethodInterface) {
            $collection = $shippingMethod->getPaymentMethods();

            $collection->map(function (PaymentMethodInterface $paymentMethod) use ($radioGroup) {
                $radioGroup->addOptionToSelect($paymentMethod->getId(), $paymentMethod->translate()->getName());
            });
        }
    }
}
