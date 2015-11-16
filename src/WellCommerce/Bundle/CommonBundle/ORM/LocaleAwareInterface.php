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

namespace WellCommerce\Bundle\CommonBundle\ORM;

/**
 * Interface LocaleAwareInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface LocaleAwareInterface
{
    /**
     * Sets locale name for translation.
     *
     * @param string $locale
     */
    public function setLocale($locale);

    /**
     * Returns this translation locale.
     *
     * @return string
     */
    public function getLocale();
}
