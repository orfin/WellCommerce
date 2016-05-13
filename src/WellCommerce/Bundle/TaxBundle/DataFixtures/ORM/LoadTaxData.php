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

use Doctrine\Common\Persistence\ObjectManager;
use WellCommerce\Bundle\DoctrineBundle\DataFixtures\AbstractDataFixture;
use WellCommerce\Bundle\TaxBundle\Entity\Tax;

/**
 * Class LoadTaxData
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LoadTaxData extends AbstractDataFixture
{
    public static $samples = [0, 3, 5, 7, 23];

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        if (!$this->isEnabled()) {
            return;
        }

        foreach (self::$samples as $val) {
            $name = sprintf('%s%s', $val, '%');
            $tax  = new Tax();
            $tax->setValue($val);
            $tax->translate($this->getDefaultLocale())->setName($name . ' VAT');
            $tax->mergeNewTranslations();
            $manager->persist($tax);
            $this->setReference('tax_' . $val, $tax);
        }

        $manager->flush();
    }
}
