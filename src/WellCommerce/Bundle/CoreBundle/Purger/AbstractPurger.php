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

namespace WellCommerce\Bundle\CoreBundle\Purger;

use WellCommerce\Bundle\CoreBundle\Helper\Doctrine\DoctrineHelperInterface;

/**
 * Class AbstractPurger
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractPurger
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
        $this->helper = $helper;
    }
}