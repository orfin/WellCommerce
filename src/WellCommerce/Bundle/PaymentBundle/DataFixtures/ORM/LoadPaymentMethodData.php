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

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use WellCommerce\Bundle\PaymentBundle\Entity\PaymentMethod;

/**
 * Class LoadPaymentData
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LoadPaymentMethodData implements FixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $cod = new PaymentMethod();
        $cod->setEnabled(1);
        $cod->setHierarchy(0);
        $cod->setProcessor('cod');
        $cod->translate('en')->setName('Cash on delivery');
        $cod->mergeNewTranslations();
        $manager->persist($cod);

        $bankTransfer = new PaymentMethod();
        $bankTransfer->setEnabled(1);
        $bankTransfer->setHierarchy(0);
        $bankTransfer->setProcessor('bank_transfer');
        $bankTransfer->translate('en')->setName('Bank transfer');
        $bankTransfer->mergeNewTranslations();
        $manager->persist($bankTransfer);

        $manager->flush();
    }
}
