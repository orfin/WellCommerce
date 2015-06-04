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

namespace WellCommerce\Bundle\CartBundle\Purger;


use WellCommerce\Bundle\CartBundle\Repository\CartRepositoryInterface;
use WellCommerce\Bundle\CoreBundle\Helper\Doctrine\DoctrineHelperInterface;
use WellCommerce\Bundle\CoreBundle\Purger\PurgerInterface;

class CartPurger implements PurgerInterface
{
    /**
     * @var DoctrineHelperInterface
     */
    protected $helper;

    /**
     * Constructor
     *
     * @param DoctrineHelperInterface $helper
     */
    public function __construct(DoctrineHelperInterface $helper)
    {
        $this->helper         = $helper;
    }

    /**
     * {@inheritdoc}
     */
    public function purge()
    {
        return $this->helper->truncateTable('WellCommerce\Bundle\CartBundle\Entity\Cart');
    }
}