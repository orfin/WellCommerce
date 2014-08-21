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

namespace WellCommerce\Bundle\MediaBundle\Uploader;

use Symfony\Component\HttpFoundation\Request;

/**
 * Interface UploaderInterface
 *
 * @package WellCommerce\Bundle\MediaBundle\Uploader
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface UploaderInterface
{
    /**
     * Checks whether passed request object is valid
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function check(Request $request);

    /**
     * Processes the request object
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function process(Request $request);

    /**
     * Returns an array containing supported extensions
     *
     * @return mixed
     */
    public function supports();
} 