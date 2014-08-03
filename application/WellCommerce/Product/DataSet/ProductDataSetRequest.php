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

namespace WellCommerce\Product\DataSet;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use WellCommerce\Core\DataSet\Request\AbstractRequest;
use WellCommerce\Core\DataSet\Request\RequestInterface;

/**
 * Class ProductDataSetRequest
 *
 * @package WellCommerce\Product\DataSet
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductDataSetRequest extends AbstractRequest implements RequestInterface
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired(array_keys($this->getDefaultOptions()));

        $resolver->setAllowedTypes($this->getDefaultOptions());
    }
}