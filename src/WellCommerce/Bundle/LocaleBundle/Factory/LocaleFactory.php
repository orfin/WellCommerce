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

use WellCommerce\Bundle\DoctrineBundle\Factory\AbstractEntityFactory;
use WellCommerce\Bundle\LocaleBundle\Entity\LocaleInterface;

/**
 * Class LocaleFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LocaleFactory extends AbstractEntityFactory
{
    /**
     * @var string
     */
    protected $supportsInterface = LocaleInterface::class;

    /**
     * @return LocaleInterface
     */
    public function create() : LocaleInterface
    {
        /** @var $locale LocaleInterface */
        $locale = $this->init();
        $locale->setCode('');
        $locale->setEnabled(true);
        $locale->setCurrency($this->getDefaultCurrency());

        return $locale;
    }
}
