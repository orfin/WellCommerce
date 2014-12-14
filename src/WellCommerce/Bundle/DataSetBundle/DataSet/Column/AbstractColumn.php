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

namespace WellCommerce\Bundle\DataSetBundle\DataSet\Column;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class AbstractColumn
 *
 * @package WellCommerce\Bundle\DataSetBundle\DataSet\Column
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractColumn
{
    protected $options = [];

    protected $optionsResolver;

    public function __construct(array $options)
    {
        $this->optionsResolver = new OptionsResolver();
        $this->configureOptions($this->optionsResolver);
        $this->options = $this->optionsResolver->resolve($options);
    }

    abstract protected function configureOptions(OptionsResolverInterface $resolver);
} 