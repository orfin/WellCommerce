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

namespace WellCommerce\Bundle\CoreBundle\Manager\Front;

use WellCommerce\Bundle\CoreBundle\Manager\ManagerInterface;
use WellCommerce\Bundle\CoreBundle\Provider\ProviderCollection;

/**
 * Interface FrontManagerInterface
 *
 * @package WellCommerce\Bundle\CoreBundle\Manager\Front
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface FrontManagerInterface extends ManagerInterface
{
    /**
     * Returns repository object
     *
     * @return \WellCommerce\Bundle\CoreBundle\Repository\RepositoryInterface
     */
    public function getRepository();

    /**
     * Sets providers collection
     *
     * @param ProviderCollection $providers
     */
    public function setProviders(ProviderCollection $providers);

    /**
     * Returns providers collection
     *
     * @return ProviderCollection
     */
    public function getProviders();

    /**
     * Returns single provider by type
     *
     * @param $type
     *
     * @return \WellCommerce\Bundle\CoreBundle\Provider\ProviderInterface
     */
    public function getProvider($type);
}
