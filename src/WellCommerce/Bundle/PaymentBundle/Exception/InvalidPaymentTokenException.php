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

namespace WellCommerce\Bundle\PaymentBundle\Exception;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class InvalidPaymentTokenException
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class InvalidPaymentTokenException extends NotFoundHttpException
{
    /**
     * InvalidPaymentTokenException constructor.
     *
     * @param null|string $token
     */
    public function __construct($token)
    {
        $msg = sprintf('Payment for given token "%s" was not found', $token);
        parent::__construct($msg);
    }
}
