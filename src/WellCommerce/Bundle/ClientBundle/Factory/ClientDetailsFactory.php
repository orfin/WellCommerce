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

use WellCommerce\Bundle\ClientBundle\Entity\ClientDetailsInterface;
use WellCommerce\Bundle\CoreBundle\Helper\Helper;
use WellCommerce\Bundle\DoctrineBundle\Factory\AbstractEntityFactory;

/**
 * Class ClientDetailsFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class ClientDetailsFactory extends AbstractEntityFactory
{
    protected $supportsInterface = ClientDetailsInterface::class;
    
    public function create() : ClientDetailsInterface
    {
        /** @var ClientDetailsInterface $details */
        $details = $this->init();
        $details->setUsername('');
        $details->setConditionsAccepted(false);
        $details->setDiscount(0);
        $details->setNewsletterAccepted(false);
        $details->setSalt(base_convert(sha1(uniqid(mt_rand(), true)), 16, 36));
        $details->setPassword('');

        return $details;
    }
}
