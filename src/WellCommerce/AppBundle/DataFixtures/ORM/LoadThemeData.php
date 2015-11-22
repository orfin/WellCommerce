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

namespace WellCommerce\AppBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use WellCommerce\AppBundle\DataFixtures\AbstractDataFixture;
use WellCommerce\AppBundle\Entity\Theme;

/**
 * Class LoadThemeData
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LoadThemeData extends AbstractDataFixture
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $theme = new Theme();
        $theme->setName('WellCommerce Default Theme');
        $theme->setFolder('wellcommerce');

        $manager->persist($theme);
        $manager->flush();

        $this->setReference('theme', $theme);
    }
}
