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

namespace WellCommerce\Bundle\SmugglerBundle\Factory;

use WellCommerce\Bundle\CoreBundle\Factory\AbstractFactory;
use WellCommerce\Bundle\SmugglerBundle\Entity\ChannelInterface;

/**
 * Class ChannelFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ChannelFactory extends AbstractFactory
{
    /**
     * @var string
     */
    protected $supportsInterface = ChannelInterface::class;

    /**
     * @return ChannelInterface
     */
    public function create()
    {
        /** @var  $channel ChannelInterface */
        $channel = $this->init();

        return $channel;
    }
}
