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

namespace WellCommerce\Bundle\PaymentBundle\Request\ParamConverter;

use Symfony\Component\HttpFoundation\Request;
use WellCommerce\Bundle\CoreBundle\Request\ParamConverter\AbstractEntityParamConverter;

/**
 * Class ProductParamConverter
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class PaymentParamConverter extends AbstractEntityParamConverter
{
    protected function findByRequestParameter(Request $request)
    {
        return $this->repository->findOneBy([
            'token'      => $request->attributes->get($this->requestAttributeName),
        ]);
    }
}
