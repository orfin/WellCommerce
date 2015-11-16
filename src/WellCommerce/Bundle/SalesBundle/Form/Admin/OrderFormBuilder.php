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
namespace WellCommerce\Bundle\SalesBundle\Form\Admin;

use Doctrine\Common\Collections\Collection;
use WellCommerce\Bundle\CoreBundle\Form\AbstractFormBuilder;
use WellCommerce\Bundle\FormBundle\Elements\ElementInterface;
use WellCommerce\Bundle\FormBundle\Elements\FormInterface;
use WellCommerce\Bundle\SalesBundle\Context\Admin\OrderContextInterface;
use WellCommerce\Bundle\SalesBundle\Entity\OrderInterface;
use WellCommerce\Bundle\SalesBundle\Entity\PaymentMethodInterface;
use WellCommerce\Bundle\SalesBundle\Entity\ShippingMethodCostInterface;
use WellCommerce\Bundle\SalesBundle\Provider\ShippingMethodProviderInterface;

/**
 * Class OrderFormBuilder
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class OrderFormBuilder extends AbstractFormBuilder
{
    /**
     * @var ShippingMethodProviderInterface
     */
    protected $shippingMethodProvider;

    /**
     * @var OrderContextInterface
     */
    protected $orderContext;

    /**
     * @param ShippingMethodProviderInterface $shippingMethodProvider
     */
    public function setShippingMethodProvider(ShippingMethodProviderInterface $shippingMethodProvider)
    {
        $this->shippingMethodProvider = $shippingMethodProvider;
    }

    /**
     * @param OrderContextInterface $orderContext
     */
    public function setOrderContext(OrderContextInterface $orderContext)
    {
        $this->orderContext = $orderContext;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormInterface $form)
    {
        $currentOrder              = $this->orderContext->getCurrentOrder();
        $shippingMethodsCollection = $this->shippingMethodProvider->getShippingMethodCostsCollection($currentOrder);
        $countries                 = $this->get('country.repository')->all();

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

        $paymentShippingData->addChild($this->getElement('select', [
            'name'        => 'shippingMethod',
            'label'       => $this->trans('order.label.shipping_method'),
            'options'     => $this->getShippingMethodOptions($shippingMethodsCollection, $currentOrder),
            'transformer' => $this->getRepositoryTransformer('entity', $this->get('shipping_method.repository'))
        ]));

        $paymentShippingData->addChild($this->getElement('select', [
            'name'        => 'paymentMethod',
            'label'       => $this->trans('order.label.payment_method'),
            'options'     => $this->getPaymentMethodOptions($shippingMethodsCollection, $currentOrder),
            'transformer' => $this->getRepositoryTransformer('entity', $this->get('payment_method.repository'))
        ]));

        $orderTotalData = $orderDetails->addChild($this->getElement('nested_fieldset', [
            'name'  => 'orderTotalData',
            'label' => $this->trans('order.heading.order_total'),
        ]));

        $orderTotalData->addChild($this->getElement('text_field', [
            'name'  => 'shippingTotal.grossAmount',
            'label' => $this->trans('order.label.order_total.shipping'),
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
            'label' => $this->trans('order.heading.addresses'),
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
            'name'  => 'billingAddress.street',
            'label' => $this->trans('client.label.address.street'),
        ]));

        $billingAddress->addChild($this->getElement('text_field', [
            'name'  => 'billingAddress.streetNo',
            'label' => $this->trans('client.label.address.street_no'),
        ]));

        $billingAddress->addChild($this->getElement('text_field', [
            'name'  => 'billingAddress.flatNo',
            'label' => $this->trans('client.label.address.flat_no'),
        ]));

        $billingAddress->addChild($this->getElement('text_field', [
            'name'  => 'billingAddress.postCode',
            'label' => $this->trans('client.label.address.post_code'),
        ]));

        $billingAddress->addChild($this->getElement('text_field', [
            'name'  => 'billingAddress.province',
            'label' => $this->trans('client.label.address.province'),
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
            'name'  => 'shippingAddress.street',
            'label' => $this->trans('client.label.address.street'),
        ]));

        $shippingAddress->addChild($this->getElement('text_field', [
            'name'  => 'shippingAddress.streetNo',
            'label' => $this->trans('client.label.address.street_no'),
        ]));

        $shippingAddress->addChild($this->getElement('text_field', [
            'name'  => 'shippingAddress.flatNo',
            'label' => $this->trans('client.label.address.flat_no'),
        ]));

        $shippingAddress->addChild($this->getElement('text_field', [
            'name'  => 'shippingAddress.postCode',
            'label' => $this->trans('client.label.address.post_code'),
        ]));

        $shippingAddress->addChild($this->getElement('text_field', [
            'name'  => 'shippingAddress.province',
            'label' => $this->trans('client.label.address.province'),
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

    /**
     * Returns shipping options for given order
     *
     * @param OrderInterface $order
     *
     * @return array
     */
    protected function getShippingMethodOptions(Collection $shippingMethodsCollection, OrderInterface $order)
    {
        $targetCurrency = $order->getCurrency();
        $options        = [];

        $shippingMethodsCollection->map(function (ShippingMethodCostInterface $shippingMethodCost) use (&$options, $targetCurrency) {
            $shippingMethod = $shippingMethodCost->getShippingMethod();

            $options[$shippingMethod->getId()] = $shippingMethod->translate()->getName();
        });

        return $options;
    }

    /**
     * Returns shipping options for given order
     *
     * @param OrderInterface $order
     *
     * @return array
     */
    protected function getPaymentMethodOptions(Collection $shippingMethodsCollection, OrderInterface $order)
    {
        $options = [];

        $shippingMethodsCollection->map(function (ShippingMethodCostInterface $shippingMethodCost) use (&$options) {
            $shippingMethod = $shippingMethodCost->getShippingMethod();
            $collection     = $shippingMethod->getPaymentMethods();

            $collection->map(function (PaymentMethodInterface $paymentMethod) use (&$options) {
                $options[$paymentMethod->getId()] = $paymentMethod->translate()->getName();
            });
        });

        return $options;
    }
}
