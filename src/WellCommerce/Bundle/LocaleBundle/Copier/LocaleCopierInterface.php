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

namespace WellCommerce\Bundle\LocaleBundle\Copier;

use WellCommerce\Bundle\LocaleBundle\Entity\LocaleInterface;

/**
 * Interface LocaleCopierInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface LocaleCopierInterface
{
    public function copyLocaleData(LocaleInterface $sourceLocale, LocaleInterface $targetLocale);
}
