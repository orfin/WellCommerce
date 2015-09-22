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

namespace WellCommerce\Bundle\ShippingBundle\Options;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ShippingOption
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ShippingOption implements ShippingOptionInterface
{
    /**
     * @var array
     */
    protected $options;

    /**
     * Constructor
     *
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        $optionsResolver = new OptionsResolver();
        $this->configureOptions($optionsResolver);
        $this->options = $optionsResolver->resolve($options);
    }

    /**
     * Configures the options
     *
     * @param OptionsResolver $resolver
     */
    protected function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired([
            'id',
            'name',
            'tax_amount',
            'net_price',
            'gross_price'
        ]);

        $resolver->setAllowedTypes([
            'id'          => 'int',
            'name'        => 'string',
            'tax_amount'  => ['int', 'float'],
            'net_price'   => ['int', 'float'],
            'gross_price' => ['int', 'float'],
        ]);
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->options['id'];
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->options['name'];
    }

    /**
     * @return float
     */
    public function getTaxAmount()
    {
        return $this->options['tax_amount'];
    }

    /**
     * @return float
     */
    public function getNetPrice()
    {
        return $this->options['net_price'];
    }

    /**
     * @return float
     */
    public function getGrossPrice()
    {
        return $this->options['gross_price'];
    }
}
