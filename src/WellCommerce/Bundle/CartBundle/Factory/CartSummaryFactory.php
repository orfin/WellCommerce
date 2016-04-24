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

namespace WellCommerce\Bundle\CartBundle\Factory;

use WellCommerce\Bundle\CartBundle\Entity\CartSummaryInterface;
use WellCommerce\Bundle\DoctrineBundle\Factory\AbstractEntityFactory;

/**
 * Class CartSummaryFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class CartSummaryFactory extends AbstractEntityFactory
{
    protected $supportsInterface = CartSummaryInterface::class;

    public function create() : CartSummaryInterface
    {
        /** @var $summary CartSummaryInterface */
        $summary = $this->init();
        $summary->setGrossAmount(0);
        $summary->setNetAmount(0);
        $summary->setTaxAmount(0);

        return $summary;
    }
}
