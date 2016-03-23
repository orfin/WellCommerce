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

namespace WellCommerce\Bundle\ClientBundle\Factory;

use WellCommerce\Bundle\ClientBundle\Entity\ClientDetails;
use WellCommerce\Bundle\ClientBundle\Entity\ClientDetailsInterface;
use WellCommerce\Bundle\DoctrineBundle\Factory\AbstractEntityFactory;

/**
 * Class ClientDetailsFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ClientDetailsFactory extends AbstractEntityFactory
{
    /**
     * @var string
     */
    protected $supportsInterface = ClientDetailsInterface::class;

    /**
     * @return ClientDetailsInterface
     */
    public function create() : ClientDetailsInterface
    {
        $details = new ClientDetails();
        $details->setConditionsAccepted(false);
        $details->setDiscount(0);
        $details->setNewsletterAccepted(false);
        $details->setSalt(base_convert(sha1(uniqid(mt_rand(), true)), 16, 36));

        return $details;
    }
}
