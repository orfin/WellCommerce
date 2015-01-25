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

namespace WellCommerce\Bundle\CoreBundle\DataSet\Column;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class AbstractColumn
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractColumn
{
    /**
     * @var array
     */
    protected $options = [];

    /**
     * Constructor
     *
     * @param array $options
     */
    public function __construct(array $options)
    {
        $optionsResolver = new OptionsResolver();
        $this->configureOptions($optionsResolver);
        $this->options = $optionsResolver->resolve($options);
    }

    /**
     * Configures column options
     *
     * @param OptionsResolver $resolver
     */
    abstract protected function configureOptions(OptionsResolver $resolver);
}
