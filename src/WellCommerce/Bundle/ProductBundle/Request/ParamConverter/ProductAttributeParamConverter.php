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

namespace WellCommerce\Bundle\ProductBundle\Request\ParamConverter;

use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use WellCommerce\Bundle\CoreBundle\Request\ParamConverter\AbstractEntityParamConverter;

/**
 * Class ProductAttributeParamConverter
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductAttributeParamConverter extends AbstractEntityParamConverter
{
    protected function findByRequestParameter(Request $request)
    {
        return $this->repository->find((int)$request->attributes->get('attribute'));
    }

    protected function getSupportedTypes()
    {
        return [
            'WellCommerce\Bundle\ProductBundle\Entity\ProductAttribute',
            'WellCommerce\Bundle\ProductBundle\Entity\ProductAttributeInterface',
        ];
    }
}
