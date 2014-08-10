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

namespace WellCommerce\Bundle\CoreBundle\Controller\Admin;

/**
 * Interface AdminControllerInterface
 *
 * @package WellCommerce\Bundle\CoreBundle\Controller\Admin
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface AdminControllerInterface
{
    const MESSAGE_TYPE_SUCCESS = 'success';
    const MESSAGE_TYPE_NOTICE  = 'notice';
    const MESSAGE_TYPE_ERROR   = 'error';
    
    /**
     * Evaluates default route for current controller. All admin controllers must have an indexAction
     *
     * @return string
     */
    public function getDefaultUrl();

    /**
     * Shorthand for adding a flash success message
     *
     * @param $message
     *
     * @return mixed
     */
    public function addSuccessMessage($message);

    /**
     * Shorthand for adding a flash error message
     *
     * @param $message
     *
     * @return mixed
     */
    public function addErrorMessage($message);

    /**
     * Translates a string using the translation service
     *
     * @param string $id Message to translate
     *
     * @return string The message
     */
    public function trans($id, $params = [], $domain = 'admin');
}