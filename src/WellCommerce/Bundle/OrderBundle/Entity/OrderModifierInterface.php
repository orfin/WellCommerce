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

namespace WellCommerce\Bundle\OrderBundle\Entity;

use WellCommerce\Bundle\DoctrineBundle\Entity\EntityInterface;

/**
 * Interface OrderModifierInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface OrderModifierInterface extends EntityInterface
{
    public function setOrder(OrderInterface $order);

    public function getName() : string;

    public function setName(string $name);

    public function getDescription() : string;

    public function setDescription(string $description);

    public function isSubtraction() : bool;

    public function setSubtraction(bool $subtraction);

    public function getHierarchy() : int;

    public function setHierarchy(int $hierarchy);

    public function getNetAmount() : float;

    public function setNetAmount(float $netAmount);

    public function getGrossAmount() : float;

    public function setGrossAmount(float $grossAmount);

    public function getTaxAmount() : float;

    public function setTaxAmount(float $taxAmount);

    public function getCurrency() : string;

    public function setCurrency(string $currency);
}
