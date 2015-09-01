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

namespace WellCommerce\Bundle\CoreBundle\Controller;

/**
 * Interface ControllerInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ControllerInterface
{
    /**
     * Returns content as json response
     *
     * @param array $content
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function jsonResponse(array $content);

    /**
     * Redirect to another url
     *
     * @param string $url
     * @param int    $status
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirectResponse($url, $status = RedirectResponse::HTTP_OK);
}
