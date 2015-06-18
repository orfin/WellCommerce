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
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ProviderAwareInterface
{
    /**
     * Sets provider instance
     *
     * @param ProviderInterface $provider
     *
     * @return void
     */
    public function setProvider(ProviderInterface $provider);

    /**
     * Returns current provider instance
     *
     * @return ProviderInterface
     */
    public function getProvider();
}
