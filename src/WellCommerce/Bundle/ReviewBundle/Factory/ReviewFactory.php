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

namespace WellCommerce\Bundle\ReviewBundle\Factory;

use WellCommerce\Bundle\CoreBundle\Factory\AbstractFactory;
use WellCommerce\Bundle\ReviewBundle\Entity\ReviewInterface;

/**
 * Class ReviewFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ReviewFactory extends AbstractFactory
{
    /**
     * @var string
     */
    protected $supportsInterface = ReviewInterface::class;

    /**
     * @return ReviewInterface
     */
    public function create()
    {
        /** @var  $review ReviewInterface */
        $review = $this->init();

        return $review;
    }
}
