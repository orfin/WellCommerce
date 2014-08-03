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

namespace WellCommerce\Core\DataSet\Request;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class AbstractRequest
 *
 * @package WellCommerce\Core\DataSet\Request
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractRequest implements RequestInterface
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
        $resolver = new OptionsResolver();
        $this->configureOptions($resolver);
        $this->options = $resolver->resolve($options);
    }

    protected function getDefaultOptions()
    {
        return [
            'starting_from' => ['int'],
            'limit'         => ['int'],
            'order_by'      => ['string'],
            'order_dir'     => ['string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function get($key)
    {
        return $this->options[$key];
    }
}