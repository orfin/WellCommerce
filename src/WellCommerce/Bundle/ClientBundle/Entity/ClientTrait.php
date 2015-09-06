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

namespace WellCommerce\Bundle\ClientBundle\Entity;

/**
 * Class ClientTrait
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
trait ClientTrait
{
    /**
     * @var Client
     *
     * @ORM\OneToOne(targetEntity="WellCommerce\Bundle\ClientBundle\Entity\Client")
     * @ORM\JoinColumn(name="client_id", referencedColumnName="id", nullable=true, onDelete="CASCADE")
     */
    protected $client;

    /**
     * @return mixed
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param null|Client $client
     */
    public function setClient(Client $client)
    {
        $this->client = $client;
    }
}
