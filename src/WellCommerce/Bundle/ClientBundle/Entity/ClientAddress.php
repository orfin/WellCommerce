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

use Knp\DoctrineBehaviors\Model\Blameable\Blameable;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use WellCommerce\Bundle\CoreBundle\Entity\AddressInterface;

/**
 * Class ClientAddress
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ClientAddress implements ClientAddressInterface
{
    use Timestampable;
    use Blameable;

    /**
     * @var int
     */
    protected $id;

    /**
     * @var ClientInterface
     */
    protected $client;

    /**
     * @var AddressInterface
     */
    protected $address;

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * {@inheritdoc}
     */
    public function setClient(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * {@inheritdoc}
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * {@inheritdoc}
     */
    public function setAddress(AddressInterface $address)
    {
        $this->address = $address;
    }
}
