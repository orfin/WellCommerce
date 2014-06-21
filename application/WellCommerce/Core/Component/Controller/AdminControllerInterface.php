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

namespace WellCommerce\Core\Component\Controller;

/**
 * Interface AdminControllerInterface
 *
 * @package WellCommerce\Core\Component\Controller
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface AdminControllerInterface
{
    /**
     * @return mixed
     */
    public function indexAction();

    /**
     * @return mixed
     */
    public function addAction();

    /**
     * @return mixed
     */
    public function editAction($id);
}