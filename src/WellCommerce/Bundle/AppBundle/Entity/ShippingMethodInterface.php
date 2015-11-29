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

namespace WellCommerce\Bundle\AppBundle\Entity;

use Doctrine\Common\Collections\Collection;
use WellCommerce\Bundle\AppBundle\Entity\CurrencyInterface;
use WellCommerce\Bundle\TaxBundle\Entity\TaxAwareInterface;
use WellCommerce\Bundle\AppBundle\Entity\BlameableInterface;
use WellCommerce\Bundle\AppBundle\Entity\TimestampableInterface;
use WellCommerce\Bundle\AppBundle\Entity\TranslatableInterface;

/**
 * Interface ShippingMethodInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ShippingMethodInterface extends TimestampableInterface, TranslatableInterface, BlameableInterface, TaxAwareInterface
{
    /**
     * @return integer
     */
    public function getId();

    /**
     * @return string
     */
    public function getCalculator();

    /**
     * @param $calculator
     */
    public function setCalculator($calculator);

    /**
     * @return Collection
     */
    public function getCosts();

    /**
     * @param Collection $costs
     */
    public function setCosts(Collection $costs);

    /**
     * @return CurrencyInterface
     */
    public function getCurrency();

    /**
     * @param CurrencyInterface $currency
     */
    public function setCurrency(CurrencyInterface $currency);

    /**
     * @return Collection
     */
    public function getPaymentMethods();
}
