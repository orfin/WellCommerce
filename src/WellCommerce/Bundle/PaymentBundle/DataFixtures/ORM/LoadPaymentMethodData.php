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
use WellCommerce\Bundle\CompanyBundle\Entity\Company;
use WellCommerce\Bundle\PaymentBundle\Entity\Payment;

/**
 * Class LoadPaymentData
 *
 * @package WellCommerce\Bundle\PaymentBundle\DataFixtures\ORM
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LoadPaymentData implements FixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        
    }
}