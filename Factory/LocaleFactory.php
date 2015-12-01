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

namespace WellCommerce\Bundle\LocaleBundle\Factory;

use WellCommerce\Bundle\LocaleBundle\Entity\Locale;
use WellCommerce\Bundle\CoreBundle\Factory\AbstractFactory;

/**
 * Class LocaleFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LocaleFactory extends AbstractFactory
{
    /**
     * @return \WellCommerce\Bundle\LocaleBundle\Entity\LocaleInterface
     */
    public function create()
    {
        $locale = new Locale();

        return $locale;
    }
}
