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
use WellCommerce\Bundle\DataSetBundle\Transformer\TransformerInterface;

/**
 * Class RouteTransformer
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class RouteTransformer implements TransformerInterface
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
     * Formats passed DateTime object to format
     *
     * @param string $value
     *
     * @return string
     */

    public function transform($value)
    {
        return $this->generator->generate($value);
    }
}
