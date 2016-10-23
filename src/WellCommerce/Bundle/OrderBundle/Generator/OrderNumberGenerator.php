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

namespace WellCommerce\Bundle\OrderBundle\Generator;

use WellCommerce\Bundle\CoreBundle\Helper\Doctrine\DoctrineHelperInterface;
use WellCommerce\Bundle\OrderBundle\Entity\OrderInterface;

/**
 * Class OrderNumberGenerator
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class OrderNumberGenerator implements OrderNumberGeneratorInterface
{
    /**
     * @var DoctrineHelperInterface
     */
    private $helper;
    
    /**
     * OrderNumberGenerator constructor.
     *
     * @param DoctrineHelperInterface $helper
     */
    public function __construct(DoctrineHelperInterface $helper)
    {
        $this->helper = $helper;
    }
    
    public function generateOrderNumber(OrderInterface $order) : string
    {
        $sql  = "SELECT MAX(CAST(orders.number AS INT)) AS last_order FROM orders WHERE confirmed = 1";
        $em   = $this->helper->getEntityManager();
        $stmt = $em->getConnection()->prepare($sql);
        $stmt->execute();
        $rs = $stmt->fetch();
        
        return $rs['last_order'] + 1;
    }
}
