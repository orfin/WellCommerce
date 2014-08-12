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

namespace WellCommerce\Bundle\TaxBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use WellCommerce\Bundle\CoreBundle\DataFixtures\AbstractDataFixture;
use WellCommerce\Bundle\TaxBundle\Entity\Tax;

/**
 * Class LoadTaxData
 *
 * @package WellCommerce\Bundle\TaxBundle\DataFixtures\ORM
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LoadTaxData extends AbstractDataFixture implements FixtureInterface, OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $taxes = [0, 3, 5, 7, 23];

        foreach ($taxes as $val) {
            $name = sprintf('%s%s', $val, '%');
            $tax  = new Tax();
            $tax->setValue($val);
            $tax->translate('pl')->setName($name . ' VAT');
            $tax->translate('en')->setName($name . ' VAT');
            $tax->translate('de')->setName($name . ' MwSt.');
            $tax->translate('fr')->setName($name . ' TVA');
            $tax->mergeNewTranslations();
            $manager->persist($tax);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }
}