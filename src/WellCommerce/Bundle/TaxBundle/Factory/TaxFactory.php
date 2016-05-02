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

namespace WellCommerce\Bundle\TaxBundle\Factory;

use WellCommerce\Bundle\DoctrineBundle\Factory\AbstractEntityFactory;
use WellCommerce\Bundle\TaxBundle\Entity\TaxInterface;

/**
 * Class TaxFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class TaxFactory extends AbstractEntityFactory
{
    /**
     * @var string
     */
    protected $supportsInterface = TaxInterface::class;
    
    /**
     * @return TaxInterface
     */
    public function create() : TaxInterface
    {
        /** @var  $tax TaxInterface */
        $tax = $this->init();
        $tax->setValue(0);
        $tax->setCreatedAt(new \DateTime());
        
        return $tax;
    }
}
