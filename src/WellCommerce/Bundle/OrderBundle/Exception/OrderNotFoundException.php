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

namespace WellCommerce\Bundle\OrderBundle\Exception;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class OrderNotFoundException
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class OrderNotFoundException extends NotFoundHttpException
{
    /**
     * Constructor
     *
     * @param int $id
     */
    public function __construct($id)
    {
        $msg = sprintf('Order with ID "%s" was not found.', $id);
        parent::__construct($msg);
    }
}
