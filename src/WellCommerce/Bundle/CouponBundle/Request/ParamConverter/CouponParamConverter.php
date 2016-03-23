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

namespace WellCommerce\Bundle\CouponBundle\Request\ParamConverter;

use Symfony\Component\HttpFoundation\Request;
use WellCommerce\Bundle\CoreBundle\Request\ParamConverter\AbstractEntityParamConverter;

/**
 * Class CouponParamConverter
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CouponParamConverter extends AbstractEntityParamConverter
{
    protected function findByRequestParameter(Request $request)
    {
        return $this->repository->findOneBy([
            'code' => (string)$request->request->get('code')
        ]);
    }
}
