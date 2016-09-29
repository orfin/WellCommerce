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

namespace WellCommerce\Bundle\RoutingBundle\DataSet\Transformer;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use WellCommerce\Component\DataSet\Transformer\AbstractDataSetTransformer;

/**
 * Class RouteTransformer
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class RouteTransformer extends AbstractDataSetTransformer
{
    /**
     * @var UrlGeneratorInterface
     */
    protected $generator;
    
    /**
     * Constructor
     *
     * @param UrlGeneratorInterface $generator
     */
    public function __construct(UrlGeneratorInterface $generator)
    {
        $this->generator = $generator;
    }
    
    /**
     * {@inheritdoc}
     */
    public function transformValue($value)
    {
        if (null === $value) {
            return '';
        }
        
        return $this->generator->generate($value);
    }
}
