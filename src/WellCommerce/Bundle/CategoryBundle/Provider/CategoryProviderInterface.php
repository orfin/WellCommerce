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

namespace WellCommerce\Bundle\CategoryBundle\Provider;

use Symfony\Component\HttpFoundation\Request;
use WellCommerce\Bundle\CoreBundle\Provider\ProviderInterface;

/**
 * Interface CategoryProviderInterface
 *
 * @package WellCommerce\Bundle\CategoryBundle\Provider
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface CategoryProviderInterface extends ProviderInterface
{
    /**
     * Returns categories tree
     *
     * @return mixed
     */
    public function getTree();

    /**
     * Returns current category
     *
     * @return mixed
     */
    public function getCurrentCategory();
}