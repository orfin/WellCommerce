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

namespace WellCommerce\Bundle\OrderBundle\Visitor;

use Doctrine\Common\Collections\Collection;
use WellCommerce\Bundle\OrderBundle\Entity\OrderInterface;

/**
 * Class OrderVisitorTraverser
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class OrderVisitorTraverser
{
    /**
     * @var Collection
     */
    private $visitors;
    
    /**
     * OrderVisitorTraverser constructor.
     *
     * @param Collection $visitors
     */
    public function __construct(Collection $visitors)
    {
        $this->visitors = $visitors;
    }
    
    public function traverse(OrderInterface $order)
    {
        $this->visitors->map(function (OrderVisitorInterface $visitor) use ($order) {
            $visitor->visitOrder($order);
        });
    }
}
