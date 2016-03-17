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

use Doctrine\Common\Collections\ArrayCollection;
use WellCommerce\Bundle\ClientBundle\Entity\ClientGroupInterface;
use WellCommerce\Bundle\DoctrineBundle\Factory\AbstractEntityFactory;

/**
 * Class ClientGroupFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ClientGroupFactory extends AbstractEntityFactory
{
    /**
     * @var string
     */
    protected $supportsInterface = ClientGroupInterface::class;

    /**
     * @return ClientGroupInterface
     */
    public function create() : ClientGroupInterface
    {
        /** @var $group ClientGroupInterface */
        $group = $this->init();
        $group->setDiscount(0);
        $group->setClients(new ArrayCollection());
        $group->setPages(new ArrayCollection());

        return $group;
    }
}
