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

namespace WellCommerce\Bundle\ProductBundle\Collection\Column;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class Column
 *
 * @package WellCommerce\Bundle\ProductBundle\Collection\Column
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Column implements ColumnInterface
{
    /**
     * Column options
     *
     * @var array
     */
    private $options = [];

    /**
     * Constructor
     *
     * @param array $options
     */
    public function __construct(array $options)
    {
        $this->optionsResolver = new OptionsResolver();
        $this->configureOptions($this->optionsResolver);
        $this->options = $this->optionsResolver->resolve($options);
    }

    /**
     * Configure column options
     *
     * @param array $options
     *
     * @return array
     */
    private function configureOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired([
            'id',
            'source',
        ]);

        $resolver->setOptional([
            'process_function',
        ]);

        $resolver->setAllowedTypes([
            'id'               => 'string',
            'source'           => 'string',
            'process_function' => ['null', 'Closure'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->options['id'];
    }

    /**
     * {@inheritdoc}
     */
    public function getSource()
    {
        return $this->options['source'];
    }

    /**
     * {@inheritdoc}
     */
    public function getProcessFunction()
    {
        return $this->options['process_function'];
    }

    /**
     * {@inheritdoc}
     */
    public function getRawSelect()
    {
        return sprintf('%s AS %s', $this->getSource(), $this->getId());
    }


} 