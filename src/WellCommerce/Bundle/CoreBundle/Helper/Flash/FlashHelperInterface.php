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

namespace WellCommerce\Bundle\CoreBundle\Helper\Flash;

/**
 * Interface FlashHelperInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface FlashHelperInterface
{
    const FLASHES_NAME       = 'flashes';
    const FLASH_TYPE_SUCCESS = 'success';
    const FLASH_TYPE_ERROR   = 'error';
    const FLASH_TYPE_NOTICE  = 'notice';

    /**
     * Adds success message
     *
     * @param string $message
     * @param array  $params
     */
    public function addSuccess(string $message, array $params = []);

    /**
     * Adds notice message
     *
     * @param string $message
     * @param array  $params
     */
    public function addNotice(string $message, array $params = []);

    /**
     * Adds error message
     *
     * @param string $message
     * @param array  $params
     */
    public function addError(string $message, array $params = []);
}
