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

namespace WellCommerce\Bundle\CoreBundle\Provider;

/**
 * Interface ProviderAwareInterface
 *
 * @package WellCommerce\Bundle\CoreBundle\Provider
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ProviderAwareInterface
{
    /**
     * 
     * @param ProviderInterface $provider
     *
     * @return mixed
     */
    public function setProvider(ProviderInterface $provider);

    public function getProvider();
} 