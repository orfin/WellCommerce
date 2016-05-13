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

namespace WellCommerce\Bundle\PaymentBundle\DataFixtures\ORM;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ObjectManager;
use WellCommerce\Bundle\DoctrineBundle\DataFixtures\AbstractDataFixture;
use WellCommerce\Bundle\PaymentBundle\Entity\PaymentMethod;

/**
 * Class LoadPaymentData
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LoadPaymentMethodData extends AbstractDataFixture
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        if (!$this->isEnabled()) {
            return;
        }

        $faker           = $this->getFakerGenerator();
        $shippingMethods = new ArrayCollection();
        $shippingMethods->add($this->getReference('shipping_method_fedex'));
        $shippingMethods->add($this->getReference('shipping_method_ups'));
        
        $cod = new PaymentMethod();
        $cod->setEnabled(1);
        $cod->setHierarchy(10);
        $cod->setProcessor('cash_on_delivery');
        $cod->translate($this->getDefaultLocale())->setName('Cash on delivery');
        $cod->setShippingMethods($shippingMethods);
        $cod->setPaymentPendingOrderStatus($this->getReference('order_status_pending_payment'));
        $cod->setPaymentFailureOrderStatus($this->getReference('order_status_payment_failed'));
        $cod->setPaymentSuccessOrderStatus($this->getReference('order_status_paid'));
        $cod->setConfiguration([]);
        $cod->mergeNewTranslations();
        $manager->persist($cod);
        
        $bankTransfer = new PaymentMethod();
        $bankTransfer->setEnabled(1);
        $bankTransfer->setHierarchy(20);
        $bankTransfer->setProcessor('bank_transfer');
        $bankTransfer->translate($this->getDefaultLocale())->setName('Bank transfer');
        $bankTransfer->setShippingMethods($shippingMethods);
        $bankTransfer->setPaymentPendingOrderStatus($this->getReference('order_status_pending_payment'));
        $bankTransfer->setPaymentFailureOrderStatus($this->getReference('order_status_payment_failed'));
        $bankTransfer->setPaymentSuccessOrderStatus($this->getReference('order_status_paid'));
        $bankTransfer->setConfiguration([
            'bank_transfer_account_number' => '1111 2222 3333 4444 5555 6666',
            'bank_transfer_account_owner'  => 'WellCommerce',
            'bank_transfer_sort_number'    => 'SORTCODE',
        ]);
        $bankTransfer->mergeNewTranslations();
        $manager->persist($bankTransfer);
        
        $payPal = new PaymentMethod();
        $payPal->setEnabled(1);
        $payPal->setHierarchy(30);
        $payPal->setProcessor('paypal');
        $payPal->translate($this->getDefaultLocale())->setName('PayPal');
        $payPal->setShippingMethods($shippingMethods);
        $payPal->setPaymentPendingOrderStatus($this->getReference('order_status_pending_payment'));
        $payPal->setPaymentFailureOrderStatus($this->getReference('order_status_payment_failed'));
        $payPal->setPaymentSuccessOrderStatus($this->getReference('order_status_paid'));
        $payPal->setConfiguration([
            'paypal_client_id'     => 'AQSJsBNhgVhtOd5t_KUp4hWEAUPRj6Xd3IRu3g_t08D0ZqFIRVrzhnJ0w9ktQMBeOFHfj-yWx78XsKiW',
            'paypal_client_secret' => 'EFe3yJq23ebDCUDZtT3vD6GOg5JcDMbNgzDzuRZVsEPbBSfkYwFxYeK-qWJHSRasy4hL3h7Ucv9v3ghM',
            'paypal_mode'          => 'sandbox',
        ]);
        $payPal->mergeNewTranslations();
        $manager->persist($payPal);
        
        $manager->flush();
        
        $this->setReference('payment_method_cod', $cod);
        $this->setReference('payment_method_bank_transfer', $bankTransfer);
    }
}
