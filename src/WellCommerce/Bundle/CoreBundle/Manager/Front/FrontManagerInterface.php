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
use WellCommerce\Bundle\CoreBundle\Provider\ProviderInterface;

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
     * Sets category provider
     *
     * @param ProviderInterface $provider
     */
    public function setProvider(ProviderInterface $provider);

    /**
     * Returns category provider
     *
     * @return ProviderInterface
     */
    public function getProvider();
}