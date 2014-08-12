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

namespace WellCommerce\Bundle\CoreBundle\Controller\Admin\Manager;

use Symfony\Component\HttpFoundation\Request;

/**
 * Interface AdminManagerInterface
 *
 * @package WellCommerce\Bundle\CoreBundle\Controller\Admin\Manager
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface AdminManagerInterface
{
    const PRE_UPDATE_EVENT  = 'pre_update';
    const POST_UPDATE_EVENT = 'post_update';
    const PRE_CREATE_EVENT  = 'pre_create';
    const POST_CREATE_EVENT = 'post_create';

    /**
     * Persists new resource
     *
     * @param         $resource
     * @param Request $request
     *
     * @return mixed
     */
    public function create($resource, Request $request);

    /**
     * Persists existing resource
     *
     * @param         $resource
     * @param Request $request
     *
     * @return mixed
     */
    public function update($resource, Request $request);

    /**
     * Returns redirect helper
     *
     * @return \WellCommerce\Bundle\CoreBundle\Helper\Redirect\RedirectHelperInterface
     */
    public function getRedirectHelper();


} 