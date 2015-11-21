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

namespace WellCommerce\SalesBundle\Purger;


use WellCommerce\CoreBundle\Purger\AbstractPurger;
use WellCommerce\CoreBundle\Purger\PurgerInterface;

class CartPurger extends AbstractPurger implements PurgerInterface
{
    /**
     * {@inheritdoc}
     */
    public function purge()
    {
        return $this->getDoctrineHelper()->truncateTable('WellCommerce\SalesBundle\Entity\Cart');
    }
}
