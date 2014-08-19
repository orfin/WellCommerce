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

namespace WellCommerce\Bundle\MediaBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use WellCommerce\Bundle\CompanyBundle\Entity\Company;
use WellCommerce\Bundle\MediaBundle\Entity\Media;

/**
 * Class LoadMediaData
 *
 * @package WellCommerce\Bundle\MediaBundle\DataFixtures\ORM
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LoadMediaData implements FixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $media = new Media();
        $media->translate('pl')->setName('szt');
        $media->translate('en')->setName('pcs');
        $media->translate('de')->setName('pcs');
        $media->translate('fr')->setName('pcs');
        $media->mergeNewTranslations();

        $manager->persist($media);
        $manager->flush();
    }
}